@if ($paginator->hasPages())
<div class="d-flex justify-content-center">
    <div class="clearfix"></div>
			<div class="pagination-container margin-top-20 margin-bottom-20 ">
				<nav class="pagination">
					<ul>
                        {{--  prev  --}}
                        @if ($paginator->onFirstPage())
                            <li class="pagination-arrow text-muted dark"><a href="#" class="ripple-effect" style="cursor: not-allowed !important"><i class="icon-material-outline-keyboard-arrow-left"></i></a></li>
                        @else
                            <li class="pagination-arrow" wire:click="previousPage" wire:loading.attr="disabled" ><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-left"></i></a></li>
                        @endif
                        {{--  prev end  --}}

                        @foreach($elements as $element)
                            @foreach($element as $page =>$url)
                                @if($page==$paginator->currentPage())
                                    <li><a href="#" class="ripple-effect current-page" wire:click="gotoPage({{ $page }})" style='cursor:not-allowed !important'>{{$page}}</a></li>
                                @else
                                    <li><a href="#" class="ripple-effect" wire:click="gotoPage({{ $page }})">{{$page}}</a></li>
                                @endif
                            @endforeach
                        
                        @endforeach
                        {{--  next  --}}
                        @if ($paginator->hasMorePages())
                            <li class="pagination-arrow text-muted dark"  wire:click="nextPage" wire:loading.attr="disabled"><a href="#" class="ripple-effect" ><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>
                        @else
                            <li class="pagination-arrow"><a href="#" class="ripple-effect" style="cursor: not-allowed !important"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>
                        @endif
                        {{--  next end  --}}
					</ul>
				</nav>
			</div>
<div class="clearfix"></div>
</div>

@endif
