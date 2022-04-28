<img src="/images/backgrounf.png" alt="">
<section class="section-card my-4">
    <div class="container">
        <div class="row">
            <!--? title  -->
            <div class="title-sub my-2">
                <div class="text">
                    <h6>
                        لحظه آخری
                    </h6>
                </div>
                <div class="text">
                    <p>روزانه از ساعت ۱۴:۰۰ الی ۲۴:۰۰، اقامتگاه‌‌های تحویل آنی با قیمتی مناسب برای امشب</p>
                </div>
            </div>
            <div class="isDesktop">
                <!--? parent (Desktop)  -->
                <div class="p-card swiper-container swiper d-flex flex-wrap">
                    <!--? swiper wrapper main  -->
                    <div class="swiper-wrapper">
                @foreach($residences as $item)
                    <!--? child  -->
                        <div class="swiper-data swiper-slide bg-white ms-3 mb-3" >
                            <div class="over-background"></div>
                            <div class="image">
{{--                                @dd($item->residenceFiles[0]->url)url--}}
{{--                                @dd($item->residenceFiles)--}}
                                <img src="{{$item->residenceFiles()->first()->url}}" alt="" />
                            </div>
                            <div class="text data-info d-flex flex-column justify-content-between">
                                <div class="up-data">
                                    <div class="title mb-1">
                                        <a href="/info/{{$item->id}}">
                                            <span class="text-white">{{$item->title}}</span>

                                        </a>
                                    </div>
                                    <div class="paragraph">
                                        <span style="color: white">تاریخ ایجاد :</span>
                                        <p class="text-white">
                                            {{jdate($item->created_at)->format('Y-m-d')}}
                                        </p>
                                    </div>
                                    <div class="text">
                                        <p class="text-white">{{collect(config('vila.types'))->firstWhere('id',$residence->specifications['type']??0)['title']??''}}</p>
                                    </div>
                                </div>
                                <div class="price d-flex justify-content-end">
                                  <a href="/info/{{$item->id}}">جزییات</a>
                                </div>
                            </div>
                        </div>
                        @endforeach


                    </div>
                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
{{--            <div class="isMobile" style="display: none;">--}}
{{--                <!--? parent (Mobile)  -->--}}
{{--                <div class="p-card d-flex">--}}
{{--                    <!--? swiper wrapper main  -->--}}
{{--                    <!--? child  -->--}}
{{--                    <div class="swiper-data bg-white ms-3 mb-3">--}}
{{--                        <div class="over-background"></div>--}}
{{--                        <div class="image">--}}
{{--                            <img src="/images/pic-01.png" alt="" />--}}
{{--                        </div>--}}
{{--                        <div class="text data-info d-flex flex-column justify-content-between">--}}
{{--                            <div class="up-data">--}}
{{--                                <div class="title mb-1">--}}
{{--                                    <span class="text-white">عنوان تایتل شما در بخش اول</span>--}}
{{--                                </div>--}}
{{--                                <div class="paragraph">--}}
{{--                                    <p class="text-white">نمونه تست پاراگراف</p>--}}
{{--                                </div>--}}
{{--                                <div class="text">--}}
{{--                                    <p class="text-white">2 خوابه ، مدل اول ، شیراز</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="price d-flex justify-content-end">--}}
{{--                                <div class="text ms-2">--}}
{{--                                    <span class="text-white">1/560/000/000</span>--}}
{{--                                </div>--}}
{{--                                <div class="unit">--}}
{{--                                    <span class="text-white">تومان</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--? child  -->--}}
{{--                    <div class="swiper-data bg-white ms-3 mb-3">--}}
{{--                        <div class="over-background"></div>--}}
{{--                        <div class="image">--}}
{{--                            <img src="/images/pic-01.png" alt="" />--}}
{{--                        </div>--}}
{{--                        <div class="text data-info d-flex flex-column justify-content-between">--}}
{{--                            <div class="up-data">--}}
{{--                                <div class="title mb-1">--}}
{{--                                    <span class="text-white">عنوان تایتل شما در بخش اول</span>--}}
{{--                                </div>--}}
{{--                                <div class="paragraph">--}}
{{--                                    <p class="text-white">نمونه تست پاراگراف</p>--}}
{{--                                </div>--}}
{{--                                <div class="text">--}}
{{--                                    <p class="text-white">2 خوابه ، مدل اول ، شیراز</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="price d-flex justify-content-end">--}}
{{--                                <div class="text ms-2">--}}
{{--                                    <span class="text-white">1/560/000/000</span>--}}
{{--                                </div>--}}
{{--                                <div class="unit">--}}
{{--                                    <span class="text-white">تومان</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
</section>
<!-- section 2 -->
<section class="section-card my-4">
    <div class="container">
        <div class="row">
            <!--? title  -->
            <div class="title-sub my-2">
                <div class="text">
                    <h6>
                        دسته بندی اقامتگاه ها
                    </h6>
                </div>
            </div>
            <!--? parent  -->
            <div class="p-card d-flex flex-wrap">
                <!--? child  -->
                <div class="c-card bg-white ms-2 mb-3">
                    <a href="detail.html">
                        <div class="image">
                            <img src="/images/pic-01.png" alt="" />
                        </div>
                        <div class="text m-2">
                            <div class="title mb-1">
                                <span>عنوان تایتل شما در بخش اول</span>
                            </div>
                            <div class="paragraph">
                                <p>نمونه تست پاراگراف</p>
                            </div>
                        </div>
                    </a>
                </div>
                <!--? child  -->
                <div class="c-card bg-white ms-2 mb-3">
                    <a href="detail.html">
                        <div class="image">
                            <img src="/images/pic-01.png" alt="" />
                        </div>
                        <div class="text m-2">
                            <div class="title mb-1">
                                <span>عنوان تایتل شما در بخش اول</span>
                            </div>
                            <div class="paragraph">
                                <p>نمونه تست پاراگراف</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script>
        const swiper = new Swiper('.swiper', {
            // Optional parameters
            direction: 'horizontal',
            loop: false,
            slidesPerView: 3.0,

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
@endpush
