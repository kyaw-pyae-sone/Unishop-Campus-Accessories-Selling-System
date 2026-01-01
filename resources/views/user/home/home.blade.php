@extends('user.layouts.master');

@section("title", "Home");

@section("content")

    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5 mt-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Campus Accessories</h1>
                        <h2></h2>
                    </div>
                    <div class="offset-5 col-lg-3 text-end mb-5 overflow-auto">
                        <select class="text-center mb-5 form-select" onchange="setFilter(event)" >
                            <option class="" @if(!request("categoryId")) selected @endif value="all">
                                    All Products
                            </option>

                            @foreach($categories as $category)
                                <option class="" @if($category -> id == request("categoryId")) selected @endif value="{{ $category -> id }}">
                                    {{ $category -> name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-3">
                                <div class="form">
                                    <form action="" method="get">

                                        <div class="input-group">
                                            <input type="text" name="searchKey" value="{{ request("searchKey")}}" class=" form-control"
                                                placeholder="Enter Search Key...">
                                            <button type="submit" class=" btn"> <i
                                                    class="fa-solid fa-magnifying-glass"></i> </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <form action="" method="get">

                                            <input type="text" name="minPrice" value="" placeholder="Minimum Price..."
                                                class=" form-control my-2">
                                            <input type="text" name="maxPrice" value="" placeholder="Maximun Price..."
                                                class=" form-control my-2">
                                            <input type="submit" value="Search" class=" btn btn-success my-2 w-100">
                                        </form>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <form action="{{ route("user#home") }}" method="get">
                                            @csrf
                                            <select name="sortingType" class="form-control w-100 bg-white mt-3">
                                                <option value="name,asc" @if(request("sortingType") == "name,asc") selected @endif>Alpha : A - Z</option>
                                                <option value="name,desc" @if(request("sortingType") == "name,desc") selected @endif>Alpha : Z - A</option>
                                                <option value="price,asc" @if(request("sortingType") == "price,asc") selected @endif>Price : Low - High</option>
                                                <option value="price,desc" @if(request("sortingType") == "price,desc") selected @endif>Price : High - Low</option>
                                                <option value="created_at,asc" @if(request("sortingType") == "created_at,asc") selected @endif>Date : Asc - Desc</option>
                                                <option value="created_at,desc" @if(request("sortingType") == "created_at,desc") selected @endif>Date : Desc - Asc</option>
                                            </select>

                                            <input type="submit" value="Sort" class=" btn btn-success my-3 w-100">
                                        </form>
                                    </div>
                                </div>

                                <a href="{{ route("user#home") }}" class="btn btn-danger my-3 w-100">Clear Filter</a>

                            </div>
                            <div class="col-9">
                                <div class="row g-4">
                                    @if(count($products) != 0)
                                        @foreach($products as $product)
                                            <div class="col-4">
                                                <div class="rounded position-relative fruite-item">
                                                    <div class="fruite-img">
                                                        <a href="{{ route("user#productDetail", $product -> id) }}"><img src="{{ asset($product -> photo != null ? "productImage/" . $product -> photo : "admin/img/product-thumbnail.png") }}" style="height: 250px"
                                                                        class="img-fluid w-100 rounded-top" alt=""></a>
                                                    </div>
                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                         style="top: 10px; left: 10px;">{{ $product -> category_name }}
                                                    </div>
                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                        <h5 class="text-start">{{ $product -> name }}</h5>
                                                        <small class="text-start d-block">{!! Str::words( $product -> description,2,"...") !!}</small>
                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                            <p class="text-dark fs-5 fw-bold mb-0">{{ $product -> price }} mmk</p>
                                                            <a href="#"
                                                               class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                                    class="fa fa-shopping-bag me-2 text-primary"></i>Buy Now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <h3>There is no products</h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="img/fruite-item-5.jpg" class="img-fluid w-100 rounded-top"
                                                    alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">Fruits</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>Grapes</h4>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do
                                                    eiusmod te incididunt</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                    <a href="#"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                            class="fa fa-shopping-bag me-2 text-primary"></i> Add to
                                                        cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="img/fruite-item-2.jpg" class="img-fluid w-100 rounded-top"
                                                    alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">Fruits</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>Raspberries</h4>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do
                                                    eiusmod te incididunt</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                    <a href="#"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                            class="fa fa-shopping-bag me-2 text-primary"></i> Add to
                                                        cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="img/fruite-item-1.jpg" class="img-fluid w-100 rounded-top"
                                                    alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">Fruits</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>Oranges</h4>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do
                                                    eiusmod te incididunt</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                    <a href="#"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                            class="fa fa-shopping-bag me-2 text-primary"></i> Add to
                                                        cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="img/fruite-item-6.jpg" class="img-fluid w-100 rounded-top"
                                                    alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">Fruits</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>Apple</h4>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do
                                                    eiusmod te incididunt</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                    <a href="#"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                            class="fa fa-shopping-bag me-2 text-primary"></i> Add to
                                                        cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="img/fruite-item-5.jpg" class="img-fluid w-100 rounded-top"
                                                    alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">Fruits</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>Grapes</h4>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do
                                                    eiusmod te incididunt</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                    <a href="#"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                            class="fa fa-shopping-bag me-2 text-primary"></i> Add to
                                                        cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="img/fruite-item-4.jpg" class="img-fluid w-100 rounded-top"
                                                    alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">Fruits</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>Apricots</h4>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do
                                                    eiusmod te incididunt</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                    <a href="#"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                            class="fa fa-shopping-bag me-2 text-primary"></i> Add to
                                                        cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-5" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="img/fruite-item-3.jpg" class="img-fluid w-100 rounded-top"
                                                    alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">Fruits</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>Banana</h4>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do
                                                    eiusmod te incididunt</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                    <a href="#"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                            class="fa fa-shopping-bag me-2 text-primary"></i> Add to
                                                        cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="img/fruite-item-2.jpg" class="img-fluid w-100 rounded-top"
                                                    alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">Fruits</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>Raspberries</h4>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do
                                                    eiusmod te incididunt</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                    <a href="#"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                            class="fa fa-shopping-bag me-2 text-primary"></i> Add to
                                                        cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="img/fruite-item-1.jpg" class="img-fluid w-100 rounded-top"
                                                    alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">Fruits</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>Oranges</h4>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do
                                                    eiusmod te incididunt</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                                                    <a href="#"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                            class="fa fa-shopping-bag me-2 text-primary"></i> Add to
                                                        cart</a>
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
        </div>
    </div>
    <!-- Fruits Shop End-->

@endsection

@section("js-script")
    <script type="text/javascript">
        function setFilter(event) {
            let parameter = event.target.value;

            console.log(parameter);

            switch (parameter){
                case "all":
                    location.href = "/user/home";
                break;

                default:
                    location.href = "/user/home?categoryId=" + parameter;
            }
        }
    </script>
@endsection
