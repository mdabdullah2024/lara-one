
<div class="chat-header clearfix">
   @include('backend.chat._header')
</div>
<div class="chat-history">

   @include('backend.chat._chat')

</div>
<div class="chat-message clearfix">
	<form action="" method="post" id="submit_message" enctype="multipart/form-data" class="mb-0">
		{{csrf_field()}}
		<div>
			<input type="hidden" name="receiver_id" value="{{ $getReceiver->id }}">
			<textarea name="message" id="ClearMessage" class="form-control emojionearea"></textarea>
		</div>
		<div class="row">
				<div class="col-lg-6 hidden-sm ">
					<a style="margin-top: 10px;" id="openFile" href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
					<input style="display:none;" type="file" name="file_name" id="file_name">
					<span id="getFileName"></span>
				</div>
			<div class="col-md-6 text-right">
				<button type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;">Send</button>
			</div>
		</div>
	</form>
</div>


