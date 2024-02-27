@foreach($getChatUser as $user)
<li class="clearfix getChatWindows @if(!empty($receiver_id)) @if($receiver_id==$user['user_id']) active @endif @endif" id="{{$user['user_id']}}">
	<img width="40px" height="40px" src="{{ $user['profile_pic'] }}" alt="avatar">
	<div class="about">
		<div class="name">{{ $user['name'] }}
			@if(!empty( $user['messagecount']))
		    <span id="clearMessage{{$user['user_id']}}" class="badge badge-danger">
		    	{{ $user['messagecount'] }}
		    </span>
		    @endif
		</div>
	<div class="status"> 
		@if(!empty($user['is_online']))
		<i class="fa fa-circle online"></i>
		@else
		<i class="fa fa-circle offline"></i>
		@endif
		{{ Carbon\Carbon::parse($user['created_date'])->diffForHumans() }}
		

	</div>
	</div>
</li>
@endforeach