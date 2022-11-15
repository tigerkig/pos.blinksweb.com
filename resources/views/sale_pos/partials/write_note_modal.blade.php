<!-- Edit Order tax Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="posWriteNote">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Note</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12 custom-pos_sidebar-note">
						<textarea rows="5" name="pos_list_note"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="posWriteNoteModalUpdate">@lang('messages.update')</button>
			    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.cancel')</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->