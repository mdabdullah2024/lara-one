@foreach($getChat as $value)
	@if($value->sender_id == Auth::user()->id)
	<li class="clearfix">
	<div class="message-data text-right">
	<span class="message-data-time">{{ Carbon\Carbon::parse($value->created_date)->diffForHumans() }}</span>
	<img style="width:40px; height: 40px;" src="{{ $value->getSender->getProfile() }}" alt="avatar">
	</div>
	<div class="message other-message float-right">
		{!! nl2br($value->message) !!}
		@if(!empty($value->file_name))
		<div>
			<div >
				<img style="border:none;" src="{{ $value->getFile() }}" width="100px" height="100px" alt="{{ $value->file_name }}">
			</div>
			<a href="{{ $value->getFile() }}" download="" target="_blank">Attachment</a>
		</div>
		@endif
	</div>
	</li>
	@else
	<li class="clearfix">
	<div class="message-data">
	<span class="message-data-time">{{ Carbon\Carbon::parse($value->created_date)->diffForHumans() }}</span>
	<img style="width:40px; height: 40px;" src="{{ $value->getSender->getProfile() }}" alt="avatar">

	</div>
	<div class="message my-message">
		{!! nl2br($value->message) !!}
		@if(!empty($value->file_name))
		<div >
				<img style="border:none;" src="{{ $value->getFile() }}" width="100px" height="100px" alt="{{ $value->file_name }}">
			</div>
		<div>
			<a href="{{ $value->getFile() }}" download="" target="_blank">Attachment</a>
		</div>
		@endif
	</div>
	</li>
	@endif
@endforeach