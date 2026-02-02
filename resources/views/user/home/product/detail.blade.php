@extends("user.layouts.master")

@section("title", "Product Detail")

@section("content")
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <a href="{{ route("user#home") }}"> Home </a> <i class=" mx-1 mb-4 fa-solid fa-greater-than"></i> Details
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="border rounded">
                                <a href="#">
                                    <img src="{{ asset(is_null($product -> photo) ? "user/img/avatar.jpg" : "productImage/" . $product -> photo) }}" class="img-fluid rounded" alt="Image">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="fw-bold">{{ $product -> name }}</h4>
                            <span class="text-danger my-3">( {{ $product -> stock }} items left ! )</span>
                            <p class="mb-3">Category: {{ $product -> category_name }} </p>
                            <h5 class="fw-bold mb-3">{{ $product -> price }} mmk</h5>
                            <div class="d-flex mb-4">
                                <span class="">
                                    @for( $start=1; $start <= $stars; $start++)
                                        <i class="fa-solid fa-star text-warning"></i>
                                    @endfor

                                    @for( $start=$stars + 1; $start <= 5; $start++)
                                        <i class="fa-regular fa-star text-warning"></i>
                                    @endfor
                                </span>
{{--                                    <i class="fa-solid fa-eye"></i>--}}

                            </div>
{{--                            <p class="mb-4">{{ $product -> description }}</p>--}}
                            <form action="{{ route("user#addCart") }}" method="post">
                                @csrf
                                <input type="hidden" name="userId" value="{{ Auth::user() -> id }}">
                                <input type="hidden" name="productId" value="{{ $product -> id }}">
                                <div class="input-group quantity mb-5" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button type="button"
                                                class="btn btn-sm btn-minus rounded-circle bg-light border">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" class="in-stock" value="{{ $product -> stock }}">
                                    <input type="text" name="count"
                                           class="form-control form-control-sm text-center border-0 cart-qty" value="@if( $product -> stock > 0) 1 @else 0 @endif">
                                    <div class="input-group-btn">
                                        <button type="button"
                                                class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                @if( $product -> stock > 0 )
                                    <button type="submit"
                                            class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"><i
                                            class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</button>
                                @endif



                                <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                        class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"><i
                                        class="fa-solid fa-star me-2 text-secondary"></i> Rate this product</button>
                            </form>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Rate this product
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route("user#productRating") }}" method="post">
                                            @csrf
                                            <div class="modal-body">

                                                <input type="hidden" name="productId" value="{{ $product -> id }}">

                                                <div class="rating-css">
                                                    <div class="star-icon">

                                                        @if($userRating == 0)
                                                            <input type="radio" name="productRating" id="rating1" value="1" checked>
                                                            <label for="rating1" class="fa fa-star"></label>

                                                            <input type="radio" name="productRating" id="rating2" value="2">
                                                            <label for="rating2" class="fa fa-star"></label>

                                                            <input type="radio" name="productRating" id="rating3" value="3">
                                                            <label for="rating3" class="fa fa-star"></label>

                                                            <input type="radio" name="productRating" id="rating4" value="4">
                                                            <label for="rating4" class="fa fa-star"></label>

                                                            <input type="radio" name="productRating" id="rating5" value="5">
                                                            <label for="rating5" class="fa fa-star"></label>
                                                        @else
                                                            @for( $start=1; $start <= $stars; $start++)
                                                                <input type="radio" name="productRating" id="rating{{$start}}" value="{{ $start }}" checked>
                                                                <label for="rating{{$start}}" class="fa fa-star"></label>
                                                            @endfor

                                                            @for( $start=$stars + 1; $start <= 5; $start++)
                                                                    <input type="radio" name="productRating" id="rating{{$start}}" value="{{ $start }}">
                                                                    <label for="rating{{$start}}" class="fa fa-star"></label>
                                                            @endfor
                                                        @endif


                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Rating</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button"
                                            role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                            aria-controls="nav-about" aria-selected="true">Description</button>
                                    <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                            id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                            aria-controls="nav-mission" aria-selected="false">Customer Comments
                                        <span class=" btn btn-sm btn-secondary rounded shadow-sm">{{ count($comments) }}</span>
                                    </button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel"
                                     aria-labelledby="nav-about-tab">
                                    <p>{{ $product -> description }}</p>
                                </div>
                                <div class="tab-pane" id="nav-mission" role="tabpanel"
                                     aria-labelledby="nav-mission-tab">

                                    @if( count($comments))
                                        @foreach( $comments as $comment)
                                            <div class="d-flex">
                                                <img src="{{ asset( $comment -> profile != null ? "user/profile/" . $comment -> profile : "user/img/avatar.jpg" ) }}" class="img-fluid rounded-circle p-3"
                                                     style="width: 100px; height: 100px;">
                                                <div class="">
                                                    <p class="" style="font-size: 14px;">{{ $comment -> created_at -> format("j-F-Y") }}</p>
                                                    <div class="d-flex justify-content-between mb-3">
                                                        <h5>{{ is_null($comment -> name) ? $comment -> nickname : $comment -> name  }}</h5>
                                                        @if( $comment -> user_id == Auth::user() -> id)
                                                            <button class="btn btn-sm btn-outline-danger shadow-sm mx-4" onclick="showAlert({{ $comment -> id }})"><i class="fa-solid fa-trash"></i> Delete Comment</button>
                                                        @endif
                                                    </div>
                                                    <p class="text-muted">{{ $comment -> message }}</p>
                                                </div>
                                            </div>

                                            <hr>
                                        @endforeach
                                    @else
                                        <h4 class="text-center my-5">There is No Comment!</h4>

                                        <hr>
                                    @endif

                                </div>
                                <div class="tab-pane" id="nav-vision" role="tabpanel">
                                    <p class="text-dark">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et
                                        tempor
                                        sit. Aliqu diam
                                        amet diam et eos labore. 3</p>
                                    <p class="mb-0">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos
                                        labore.
                                        Clita erat ipsum et lorem et sit</p>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route("user#productComment") }}" method="post">
                            @csrf
                            <input type="hidden" name="productId" value="{{ $product -> id }}">
                            <h4 class="mb-5 fw-bold">
                                Leave a Comments
                            </h4>

                            <div class="row g-1">
                                <div class="col-lg-12">
                                        <textarea name="comment" id="" class="form-control shadow-sm @error("comment") is-invalid @enderror" style="resize: none" cols="30"
                                                  rows="8" placeholder="Your Review *" spellcheck="false">{{ old("comment") }}</textarea>
                                        @error("comment")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between py-3 mb-5">
                                        <button type="submit"
                                                class="btn border border-secondary text-primary rounded-pill px-4 py-3">
                                            Post
                                            Comment</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="vesitable">
                <div class="owl-carousel vegetable-carousel justify-content-center">


                    <div class="border border-primary rounded position-relative vesitable-item">
{{--                        <div class="vesitable-img">--}}
{{--                            <img src="{{ asset('product/' . $item->image) }}" style="height: 250px"--}}
{{--                                 class="img-fluid w-100 rounded-top" alt="">--}}
{{--                        </div>--}}
{{--                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute"--}}
{{--                             style="top: 10px; right: 10px;">{{ $item->category_name }}</div>--}}
{{--                        <div class="p-4 pb-0 rounded-bottom">--}}
{{--                            <h4>{{ $item->name }}</h4>--}}
{{--                            <p>{{ Str::words($item->description, 15, '...') }}</p>--}}
{{--                            <div class="d-flex justify-content-between flex-lg-wrap">--}}
{{--                                <p class="text-dark fs-5 fw-bold">{{ $item->price }} mmk</p>--}}
{{--                                <a href="#"--}}
{{--                                   class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i--}}
{{--                                        class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->
@endsection

@section("js-script")
    <script type="text/javascript">
        function showAlert(id){
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = "/user/product/comment/delete/" + id;
                }
            });
        }
    </script>
@endsection
