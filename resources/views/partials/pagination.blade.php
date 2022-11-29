@if ($users->count() > 0)
    <div class="geodir-loop-paging-container">
        <nav class="geodir-pagination">
            <ul class='page-numbers'>
                @if(request('page') != 1)
                    <li><a class="prev page-numbers"
                           href="{{ url('/') . '?' . http_build_query(array_merge(request()->query(), ['page' => (request('page') ?? 1) - 1])) }}">←</a>
                    </li>
                @endif


                @foreach(range(1, $users->lastPage()) as $page)
                    @if ($page == request('page'))
                        <li><span aria-current="page" class="page-numbers current">{{ $page }}</span></li>
                    @else
                        <li><a class="page-numbers"
                               href="{{ url('/') . '?' . http_build_query(array_merge(request()->query(), ['page' => $page])) }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                @if($users->lastPage() != request('page'))
                    <li><a class="next page-numbers"
                           href="{{ url('/') . '?' . http_build_query(array_merge(request()->query(), ['page' => (request('page') ?? 1) + 1])) }}">→</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
