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
                                    {{ Form::open(['url' => 'uad/editSubMenuDetail', 'id' => 'editSubMenuForm']) }}

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="id" value="{{ $subMenu->id }}">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label>Main Navigation Name</label>
                                        <select class="form-control select2" name="main_navigation_name"
                                            id="main_navigation_name">
                                            <option value="">Select Main Navigation</option>
                                            @foreach ($MainMenuTitles as $key => $y)
                                                <option value="{{ $y->id . '_' . $y->title_id }}"
                                                    {{ $y->id == $subMenu->m_parent_code ? 'selected' : '' }}>
                                                    {{ $y->title }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label>Sub Navigation Title Name</label>
                                        <input type="text" name="sub_navigation_title_name"
                                            id="sub_navigation_title_name" value="{{ $subMenu->name }}"
                                            class="form-control" />
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label>Sub Navigation Url</label>
                                        <input type="text" name="sub_navigation_url" id="sub_navigation_url"
                                            value="{{ $subMenu->m_controller_name }}" class="form-control" />
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label>Page Type</label>
                                        <select class="form-control" name="page_type" id="page_type">
                                            <option value="1" {{ $subMenu->page_type == 1 ? 'selected' : '' }}>
                                                Outer Page</option>
                                            <option value="2" {{ $subMenu->page_type == 2 ? 'selected' : '' }}>
                                                Inner Page</option>
                                        </select>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                        <button type="reset" id="reset" class="btn btn-primary">Clear
                                            Form</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
