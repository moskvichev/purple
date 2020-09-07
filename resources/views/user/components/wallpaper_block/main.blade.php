<!-- панель навигации по профиль Страница / Друзья / Фото / Видео -->
<div class="container">
	<div class="row">
		<div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="ui-block">
				<div class="top-header">
					<div class="top-header-thumb">
						<img src="{{ Str::startsWith($user->wallpaper, 'http') ? $user->wallpaper : asset($user->wallpaper)}}" alt="wallpaper" id="wallpaper">
					</div>
					<div class="profile-section">
						<div class="row">
							<div class="col col-lg-5 col-md-5 col-sm-12 col-12">
								<ul class="profile-menu">
									<li>
										<a href="#">Моя страница</a>
									</li>
									<li>
										<a href="#">Друзья</a>
									</li>
								</ul>
							</div>
							<div class="col col-lg-5 ml-auto col-md-5 col-sm-12 col-12">
								<ul class="profile-menu">
									<li>
										<a href="#">Фото</a>
									</li>
									<li>
										<a href="#">Видео</a>
									</li>
								</ul>
							</div>
                        </div>
                        <div class="control-block-button-left">
                            
                        <div class="wheel wheel__red">
  
                            <div class="wheel__inner__red">
                                <div class="wheel__content__red">п</div>
                                <div class="wheel__content__red">о</div>
                                <div class="wheel__content__red">с</div>
                                <div class="wheel__content__red">т</div>
                            </div>
                            <div class="btn btn-control bg-red" onmouseover="changeItemRed()" onmouseout="rechangeItemRed()" data-toggle="tooltip" data-placement="top" title="">
                                <svg class="olymp-blog-icon"><use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-blog-icon') }}"></use></svg>                                
                            </div>
                        </div>
                            
                        <div class="wheel wheel__green">  
                            
                            <div class="wheel__inner__green">
                                <div class="wheel__content__green">п</div>
                                <div class="wheel__content__green">у</div>
                                <div class="wheel__content__green">т</div>
                                <div class="wheel__content__green">ь</div>                                
                            </div>
                            <div class="btn btn-control bg-green" onmouseover="changeItemGreen()" onmouseout="rechangeItemGreen()" data-toggle="tooltip" data-placement="top" title="">
                                <svg class="olymp-add-a-place-icon"><use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-add-a-place-icon') }}"></use></svg>
                            </div>
                        </div>

                        <div class="wheel wheel__yellow">  
                            
                            <div class="wheel__inner__yellow">
                                <div class="wheel__content__yellow">ф</div>
                                <div class="wheel__content__yellow">о</div>
                                <div class="wheel__content__yellow">т</div>
                                <div class="wheel__content__yellow">о</div>
                            </div>
                            <div class="btn btn-control bg-yellow" onmouseover="changeItemYellow()" onmouseout="rechangeItemYellow()" data-toggle="tooltip" data-placement="top" title="">
                                <svg class="olymp-photos-icon"><use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-photos-icon') }}"></use></svg>    
                            </div>
                        </div>

						</div>
						<div class="control-block-button">
                            
                                @if (auth()->user()->requestedFriendships->where('user_id', $user->id)->isEmpty() && $user->id !=auth()->user()->id && auth()->user()->friends->where('friend_id', $user->id)->isEmpty() && auth()->user()->friendshipRequests->where('friend_id', $user->id)->isEmpty())
                                    <div class="btn btn-control bg-blue more append" data-toggle="tooltip" data-placement="top">
                                        <svg class="olymp-happy-face-icon"><use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-happy-face-icon') }}"></use></svg>
                                        <ul class="more-dropdown more-with-triangle triangle-bottom-right">
                                            <li>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('request-{{ $user->id }}').submit();">
                                                    <form id="request-{{ $user->id }}" action="{{ route('user.friendship_request.store') }}" method="POST" style="display: none;">
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                                        <input type="hidden" name="friend_id" value="{{ $user->id }}">
                                                    </form>
                                                    Запросить Дружбу
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                                @if (!auth()->user()->friendshipRequests->where('friend_id', $user->id)->isEmpty())
                                    <div class="btn btn-control bg-yellow more append" data-toggle="tooltip" data-placement="top">
                                        <svg class="olymp-happy-face-icon"><use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-happy-face-icon') }}"></use></svg>
                                        <ul class="more-dropdown more-with-triangle triangle-bottom-right">
                                            <li>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('request-{{ $user->id }}').submit();">
                                                    <form id="request-{{ $user->id }}" action="{{ route('user.friendship_request.destroy', ['friendship_request' => auth()->user()->friendshipRequests->where('friend_id', $user->id)->first()->id]) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    Отменить запрос на Дружбу
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                                @if (!auth()->user()->requestedFriendships->where('user_id', $user->id)->isEmpty())
                                    <div class="btn btn-control bg-orange more append" data-toggle="tooltip" data-placement="top">
                                        <svg class="olymp-happy-face-icon"><use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-happy-face-icon') }}"></use></svg>

                                        <ul class="more-dropdown more-with-triangle triangle-bottom-right">
                                            <li>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('accept-request-{{ auth()->user()->requestedFriendships->where('user_id', $user->id)->first()->id }}').submit();">
                                                    <form id="accept-request-{{ auth()->user()->requestedFriendships->where('user_id', $user->id)->first()->id }}" action="{{ route('user.friends.store') }}" method="POST" style="display: none;">
                                                        @csrf
                                                        <input type="hidden" name="requested_friendship" value="{{ auth()->user()->requestedFriendships->where('user_id', $user->id)->first() }}">
                                                    </form>
                                                    Принять Дружбу
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('request-del-{{ auth()->user()->requestedFriendships->where('user_id', $user->id)->first()->id }}').submit();">
                                                    <form id="request-del-{{ auth()->user()->requestedFriendships->where('user_id', $user->id)->first()->id }}" action="{{ route('user.friendship_request.destroy', ['friendship_request' => auth()->user()->requestedFriendships->where('user_id', $user->id)->first()]) }}" method="POST" style="display: none;">
                                                        @method('DELETE')
                                                        @csrf
                                                    </form>
                                                    Отвергнуть Дружбу
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                                @if (!$user->friends->where('friend_id', auth()->user()->id)->isEmpty())
                                    <div class="btn btn-control bg-green more append" data-toggle="tooltip" data-placement="top">
                                        <svg class="olymp-happy-face-icon"><use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-happy-face-icon') }}"></use></svg>

                                        <ul class="more-dropdown more-with-triangle triangle-bottom-right">
                                            <li>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('request-del-{{ $user->friends->where('friend_id', auth()->user()->id)->first()->id }}').submit();">
                                                    <form id="request-del-{{ $user->friends->where('friend_id', auth()->user()->id)->first()->id }}" action="{{ route('user.friends.destroy', ['friend' => $user->friends->where('friend_id', auth()->user()->id)->first()->id]) }}" method="POST" style="display: none;">
                                                        @method('DELETE')
                                                        @csrf
                                                    </form>
                                                    Разорвать Дружбу
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                                    <a href="#" class="btn btn-control bg-purple" data-toggle="tooltip" data-placement="top" title="Настройки" id="bg-purple">
                                        <svg class="olymp-chat---messages-icon"><use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-chat---messages-icon') }}"></use></svg>
                                    </a>
                                @can('update', $user)
                                    <div class="btn btn-control bg-primary more append">
                                        <svg class="olymp-settings-icon"><use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-settings-icon') }}"></use></svg>

                                        <ul class="more-dropdown more-with-triangle triangle-bottom-right">
                                            <li>
                                                <a href="#" class="profile-photo-modal-link" data-toggle="modal" data-target="#update-header-photo" data-upload-type="avatar">Фото профиля</a>
                                            </li>
                                            <li>
                                                <a href="#" class="profile-photo-modal-link" data-toggle="modal" data-target="#update-header-photo" data-upload-type="wallpaper">Главное Фото</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('user.edit', $user->id) }}">Настройки профиля</a>
                                            </li>
                                        </ul>
                                    </div>
                                @endcan
                                                      
						</div>
					</div>
					<div class="top-header-author">
						<a href="#" class="author-thumb revealator-zoomin">
							<img src="{{ Str::startsWith($user->avatar, 'http') ? $user->avatar : asset($user->avatar)}}" class="author-image" alt="author">
						</a>
						<div class="author-content">
							<a href="" class="h4 author-name">{{ $user->full_name }}</a>
							<div class="country">{{ $user->location }}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ... окончание панели навигации -->
@component('user.components.wallpaper_block.modal_photo')@endcomponent
@section('scripts')
<script>
    function rotateMainRed(value) {
    let wheelInnerRed = document.querySelectorAll('.wheel__inner__red');
    deg = 100;
    for (let item of wheelInnerRed) {
      item.style.transform = `rotate(${deg}deg)`;
      item.style.color = 'red';
      deg += value;
    }
    return value
    }
rotateMainRed(10);

function rotateMainGreen(value) {
    let wheelInnerGreen = document.querySelectorAll('.wheel__inner__green');
    deg = -121;
    for (let item of wheelInnerGreen) {
      item.style.transform = `rotate(${deg}deg)`;
      item.style.color = 'green';
      deg += value;
    }
    return value
    }
rotateMainGreen(10);

function rotateMainYellow(value) {
    let wheelInnerYellow = document.querySelectorAll('.wheel__inner__yellow');
    deg = -111;
    for (let item of wheelInnerYellow) {
      item.style.transform = `rotate(${deg}deg)`;
      item.style.color = 'black';
      deg += value;
    }
    return value
    }
rotateMainYellow(10);
  
function rotateOutherRed(value) {
    let wheelContentRed = document.querySelectorAll('.wheel__content__red');
    deg = 0;
    for (let item of wheelContentRed) {
      item.style.transform = `rotate(${deg}deg)`
      deg += value;
    }
}
rotateOutherRed(14);

function rotateOutherGreen(value) {
    let wheelContentGreen = document.querySelectorAll('.wheel__content__green');
    deg = 0;
    for (let item of wheelContentGreen) {
      item.style.transform = `rotate(${deg}deg)`
      deg += value;
    }
}
rotateOutherGreen(14);

function rotateOutherYellow(value) {
    let wheelContentYellow = document.querySelectorAll('.wheel__content__yellow');
    deg = 0;
    for (let item of wheelContentYellow) {
      item.style.transform = `rotate(${deg}deg)`
      deg += value;
    }
}
rotateOutherYellow(14);

function changeItemRed() {
  document.querySelector('.wheel__red').style.backgroundColor = 'antiquewhite';
  document.querySelector('.wheel__red').style.transition = '0.5s';
  document.querySelectorAll('.wheel__inner__red')[0].style.opacity = '1';
  document.querySelectorAll('.wheel__inner__red')[0].style.transform = 'rotate(-79deg)';
  document.querySelectorAll('.wheel__inner__red')[0].style.transition = 'all 2s ease-in-out';
}
function rechangeItemRed() {
  document.querySelector('.wheel__red').style.backgroundColor = 'unset';
  document.querySelectorAll('.wheel__inner__red')[0].style.opacity = '0';
}

function changeItemGreen() {
  document.querySelector('.wheel__green').style.backgroundColor = '#c7fcda';
  document.querySelector('.wheel__green').style.transition = '0.5s';
  document.querySelectorAll('.wheel__inner__green')[0].style.opacity = '1';
  document.querySelectorAll('.wheel__inner__green')[0].style.transform = 'rotate(-79deg)';
  document.querySelectorAll('.wheel__inner__green')[0].style.transition = 'all 2s ease-in-out';
}
function rechangeItemGreen() {
  document.querySelector('.wheel__green').style.backgroundColor = 'unset';
  document.querySelectorAll('.wheel__inner__green')[0].style.opacity = '0';
}

function changeItemYellow() {
  document.querySelector('.wheel__yellow').style.backgroundColor = '#fcf8d1';
  document.querySelector('.wheel__yellow').style.transition = '0.5s';
  document.querySelectorAll('.wheel__inner__yellow')[0].style.opacity = '1';
  document.querySelectorAll('.wheel__inner__yellow')[0].style.transform = 'rotate(-79deg)';
  document.querySelectorAll('.wheel__inner__yellow')[0].style.transition = 'all 2s ease-in-out';
}
function rechangeItemYellow() {
  document.querySelector('.wheel__yellow').style.backgroundColor = 'unset';
  document.querySelectorAll('.wheel__inner__yellow')[0].style.opacity = '0';
}
// let controlBlockButtonsRight = document.querySelector('.append');
// let controlBlockButtonsLeft = document.querySelector('.control-block-button-left');
// let bgPurple = document.querySelector('#bg-purple');

// if (screen.width <= '768') {
//   controlBlockButtonsRight.remove();
//   controlBlockButtonsLeft.append(controlBlockButtonsRight, bgPurple);
//   document.querySelector('#bg-purple').style.marginLeft = '3px';
// }
$(document).ready(function(){
    if ($(window).width() <= 768){
        $('.wheel').contents().unwrap();
        $('.wheel__inner__red').remove();
        $('.wheel__inner__green').remove();
        $('.wheel__inner__yellow').remove();
    }
});

</script>
@endsection
