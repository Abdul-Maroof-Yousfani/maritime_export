<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="well">
            <div class="dp_sdw">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span class="subHeadingLabelClass">Edit Main Menu Title</span>
                            </div>
                        </div>
                        <div class="lineHeight">&nbsp;</div>
                        <div class="panel">
                            <div class="panel-body">
                                <div class="row">
                                    <?php
                                    echo Form::open(['url' => 'uad/editMainMenuTitleDetail', 'id' => 'editMainMenuTitleForm']);
                                    ?>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="id" value="{{ $menu->id }}">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label>Main Navigation Name</label>
                                        <input type="text" name="main_menu_name" id="main_menu_name"
                                            value="{{ $menu->main_menu_id }}" class="form-control" />
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label>Sub Navigation Title Name</label>
                                        <input type="text" name="title_name" id="title_name"
                                            value="{{ $menu->title }}" class="form-control" />
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label>Menu Type</label>
                                        <select type="text" name="menu_type" id="menu_type" class="form-control">
                                            <option value="1" {{ ($menu->menu_type == 1) ? 'selected' : '' }}>Company
                                            </option>
                                            <option value="2" {{ ($menu->menu_type == 2) ? 'selected' : '' }}>Master
                                            </option>
                                        </select>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                        <button type="reset" id="reset" class="btn btn-primary">Clear
                                            Form</button>

                                        <?php
                                        //echo Form::submit('Click Me!');
                                        ?>
                                    </div>
                                    <?php
                                    echo Form::close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
