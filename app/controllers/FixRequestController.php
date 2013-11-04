<?php

class FixRequestController extends BaseController {

    /**
    * Display a listing of fix requests
    *
    * @return Response
    */
    public function getIndex()
    {
        $fixrequests = FixRequest::all();
        foreach($fixrequests as &$fixrequest) {
            $post = Post::find($fixrequest['post_id']);
            $user = User::find($post['user_id']);
            $tags = $post->tags;

            $fixrequest['text'] = UtilFunctions::truncateString($post['text'], 220);
            $fixrequest['user_id'] = $post['user_id'];
            $fixrequest['username'] = $user['username'];
            $fixrequest['user_image'] = $user['user_image'];
            $fixrequest['created_at_pretty'] = UtilFunctions::prettyDate($fixrequest['created_at']);
        }
        return View::make('fixrequests.index', array('fixrequests' => $fixrequests));
    }

    /**
    * Displays a single fix request
    *
    * @return Response
    */
    public function getShow($id)
    {
        $fixrequest = FixRequest::find($id);
        return View::make('fixrequests.show',
            array('fixrequest' => $fixrequest, 'id' => $id)
        );
    }

    /**
     * Show the form for creating a fix request
     *
     * @return Response
     */
    public function getCreate()
    {
        return View::make('fixrequests.create');
    }

    public function postCreate() 
    {
        $rules = array(
            'title' => 'required|min:4',
            'category' => 'required|in:1,2,3,4',
            'description' => 'required|min:20',
            'tags' => 'required',
            'city' => 'required',
            'location' => 'required',
            'daysForOffer' => 'required|numeric',
            'value' => 'required|numeric'
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()) {

            DB::transaction(function()
            {
                $notifiable = new Notifiable();
                $notifiable->save();

                $post = new Post(array(
                    "text" => Input::get('description'),
                    "user_id" => 1
                ));
                $post = $notifiable->post()->save($post);

                $fixrequest = new FixRequest(array(
                    'title' => Input::get('title'),
                    'state' => 'active',
                    'daysForOffer' => Input::get('daysForOffer'),
                    'value' => Input::get('value')
                ));
                $fixrequest = $post->fixrequest()->save($fixrequest);

                // needs to add the category

                $tag_list = explode(",", Input::get('tags'));
                foreach($tag_list as $tag_name) {
                    $tag = null;

                    if(!Tag::exists($tag_name)) {
                        $tag = new Tag(array("name" => $tag_name));
                        $tag->save();
                    } else {
                        $tag = Tag::getTagByName($tag_name);
                    }
                    $fixrequest->tags()->save($tag);
                }
            });
            return Redirect::to('fixrequests/index');
        } else {
            return Redirect::to('fixrequests/create')->withInput()->withErrors($validator);
        }
        
        //$data = Input::all();

        // return Input::file('photos')->getClientOriginalName();
        // $file = Input::file('photos');

        //echo json_encode($data);
        //var_dump($file->getFileName());
    }

    public function comments() 
    {
        return $this->hasMany('Comment');
    }

    public function fixoffers() 
    {
        return $this->hasMany('FixOffer');
    }
}