<div class="delete-modal modal fade" id="delete-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('base.delete') }}</h4>
                </div>
                <div class="modal-body">
                    <p>
                        {!! trans('base.are_you_sure_delete', ['name' => '\'<strong class="text"></strong>\'']) !!}
                    </p>
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('forms.close') }}</button>
                    <button type="submit" class="btn btn-primary submit">{{ trans('forms.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>