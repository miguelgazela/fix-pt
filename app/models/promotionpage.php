<?php

class PromotionPage extends Eloquent {
    
    protected $fillable = array('title', 'city', 'concelho');

    public function post()
    {
        return $this->belongsTo('Post');
    }

    public function category()
    {
        return $this->belongsTo('Category');
    }

    public static function recent($category)
    {
        if($category != null) {
            return PromotionPage::whereRaw('category_id = ?', array($category))->orderBy('created_at', 'DESC');
        }
        return PromotionPage::orderBy('created_at', 'DESC');
    }
    
    public static function recent_promotion_pages($params,$local,$category=null)
    {
        if(is_null($params) || $params == "") {
            if(is_null($local) || $local == "") {
                return PromotionPage::recent($category);
            }
            else {
                return PromotionPage::recent($category)->whereRaw("city = ?", array(ucfirst(strtolower($local))));
            }
        }
        else {
            if(is_null($local) || $local == "") {
                return PromotionPage::recent($category)->where("title","like","%".$params."%");
            }
            else {
                return PromotionPage::recent($category)->where("title","like","%".$params."%")->whereRaw("city = ?", array(ucfirst(strtolower($local))));              
            }
        }
    }
    
    public static function popular($category)
    {
		return PromotionPage::join('posts', 'promotion_pages.post_id', '=', 'posts.id')
            ->join('jobs', 'posts.user_id', '=', 'jobs.fixer_id')
            ->select(DB::raw('*, count(*) as jobammount'))
            ->groupBy('posts.user_id')
            ->orderBy('jobammount','desc');
	}
    
    public static function popular_promotion_pages($params,$local,$category=null)
    {
        if(is_null($params) || $params == "") {
            if(is_null($local) || $local == "") {
                return PromotionPage::popular($category);
            }
            else {
                return PromotionPage::popular($category)->whereRaw("city = ?", array(ucfirst(strtolower($local))));
            }
        }
        else {
            if(is_null($local) || $local == "") {
                return PromotionPage::popular($category)->where("title","like","%".$params."%");
            }
            else {
                return PromotionPage::popular($category)->where("title","like","%".$params."%")->whereRaw("city = ?", array(ucfirst(strtolower($local))));
            }
        }
    }

    public static function getPromotionPage($id)
    {
        return PromotionPage::with(array('post'))->find($id);
    }

    public static function isTherePromotionPage()
    {
        $id1 = Auth::user()->id;
        $query = "(select promotion_pages.post_id from promotion_pages INNER JOIN posts ON promotion_pages.post_id = posts.id AND posts.user_id = '".$id1."')";
        if(DB::select(DB::raw($query)))
        {
            //Utilfunctions::dump(DB::select(DB::raw($query)));
            return true;
        }
        
        //Utilfunctions::dump(DB::select(DB::raw($query)));
        return false;
    }

    public static function getPromotionPageID()
    {
        $id1 = Auth::user()->id;
        $query = "(select promotion_pages.id from promotion_pages INNER JOIN posts ON promotion_pages.post_id = posts.id AND posts.user_id = '".$id1."')";
        return DB::select(DB::raw($query));
    }

    public static function getPromotionPageNoId()
    {
        $id1 = Auth::user()->id;
        $query = "(select promotion_pages.id, promotion_pages.post_id, promotion_pages.title, posts.text, promotion_pages.category_id from promotion_pages INNER JOIN posts ON promotion_pages.post_id = posts.id AND posts.user_id = '".$id1."')";
        return DB::select(DB::raw($query));
    }

    public static function getBestFixers()
    {
        return Job::with('user')->select(DB::raw("*, avg(score) as rating"))->groupBy('fixer_id')->orderBy('rating','desc')->take(3)->get();
    }
}

?>