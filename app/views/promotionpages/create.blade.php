@extends('promotionpages/layout')

@section('content')
<div class="row">
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="{{URL::to('/')}}">Fix.pt</a></li>
            <li><a href="{{URL::to('promotionpages/index/recent')}}">Promotion Page</a></li>
            <li class="active">Create new</li>
        </ol>
        <div class="well well-lg">
            {{ Form::open(array(
                "url" => "promotionpages/create",
                "id" => "promotionpage-form",
                "role" => "form",
                "files" => true)
            )}}
                <div class="form-group <?php echo ($errors->has('title')) ? "has-error" : ""; ?>">
                    {{ Form::label("title", "Title", array("class" => "control-label")) }}
                    {{ Form::text("title", Input::old('title'), array(
                        "id" => "promotionpage-title",
                        "placeholder" => "Enter a short but explicit title",
                        "class" => "form-control"
                    ))}}
                    <p class="help-block"><?php echo $errors->first('title') ?></p>
                </div>
                <div class="form-group">
                    <label style="display: block;" for="category">Category</label>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary">
                            {{ Form::radio("category", "1", array("id" => "category_1")) }} Home Improvement
                        </label>
                        <label class="btn btn-primary">
                            {{ Form::radio("category", "2", array("id" => "category_2")) }} Gardening
                        </label>
                        <label class="btn btn-primary">
                            {{ Form::radio("category", "3", array("id" => "category_3")) }} Mechanics
                        </label>
                        <label class="btn btn-primary">
                            {{ Form::radio("category", "4", array("id" => "category_4")) }} Electronics
                        </label>
                        <label class="btn btn-primary">
                            {{ Form::radio("category", "5", array("id" => "category_5")) }} Appliances
                        </label>
                        <p class="help-block"><?php echo $errors->first('category') ?></p>
                    </div>
                </div>
                <div class="form-group <?php echo ($errors->has('description')) ? "has-error" : ""; ?>">
                    {{ Form::label("body", "Body", array("class" => "control-label")) }}
                    {{ Form::textarea("body", "", array(
                        "class" => "form-control",
                        "rows" => 20,
                        "placeholder" => "Enter a detailed description of your skills"
                    ))}}
                    <p class="help-block"><?php echo $errors->first('description') ?></p>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group <?php echo ($errors->has('city')) ? "has-error" : ""; ?>">
                            {{ Form::label("city", "City", array("class" => "control-label")) }}
                            {{ Form::text("city", "", array(
                                "class" => "form-control",
                                "id" => "promotionpage-city",
                                "placeholder" => "Enter city"
                            ))}}
                            <p class="help-block"><?php echo $errors->first('city') ?></p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group <?php echo ($errors->has('location')) ? "has-error" : ""; ?>">
                            {{ Form::label("location", "Location", array("class" => "control-label")) }}
                            {{ Form::text("location", "", array(
                                "class" => "form-control",
                                "id" => "promotionpage-location",
                                "placeholder" => "Enter location"
                            ))}}
                            <p class="help-block"><?php echo $errors->first('location') ?></p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <!-- {{ Form::label("photos", "Add photos") }}
                    {{ Form::file('photos[]', array('multiple' => true))}} -->
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            <!-- </form> -->
            {{ Form::close() }}
        </div>
    </div>
    <div class="col-md-4">
        <div class="well well-sm sidebar-steps">
            <h3 class="text-center">How you can make a good request</h1>
            <ol class="sidebar-ol">
                <li>Use a clear title and a detailed description to describe your request</li>
                <li>Chose the right category and add meaningful tags</li>
                <li>Upload some photos to show what needs to be repaired</li>
            </ol>
        </div>
    </div>
</div>
@stop
