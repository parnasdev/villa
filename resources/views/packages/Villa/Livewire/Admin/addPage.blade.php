<form wire:submit.prevent="submit">
    {{--    @dd($this->getErrorBag())--}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 d-flex justify-content-between">
                <div class="card col-lg-8">
                    <div class="card-header col-xl-12 col-lg-12 col-12">
                        <h6>اضافه کردن اقامتگاه</h6>
                    </div>
                    <div class="d-flex flex-column p-3">
                        <div class="d-flex w-100 justify-content-between">
                            <div class="w-100 flex-wrap d-flex justify-content-between">
                                <div class="item-villa">
                                    <label for="">نام اقامتگاه</label>
                                    <x-parnas.inputs.text
                                        wire:model.defer="req.title"
                                        type="text"
                                        placeholder="مثلا :ویلای استخردار متل قو"></x-parnas.inputs.text>
                                    @error('req.title')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="item-villa">
                                    <label for="">شماره همراه سرپرست</label>
                                    <input
                                        type="text"
                                        wire:model.defer="req.mobile"

                                        placeholder="تلفن تماس مالک اقامتگاه"
                                    />
                                    @error('req.mobile')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="item-villa">
                                    <label for="">استان ها</label>
                                    <select
                                        class="valid col-xl-4 col-lg-4 col-12 me-2"
                                        id="Capacity"
                                        wire:model="req.province_id"
                                        name="Capacity">
                                        @foreach($provinces as $p)
                                            <option value="{{$p->id}}">{{$p->title}}</option>
                                        @endforeach

                                    </select>
                                    @error('req.province_id')
                                    <p>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="item-villa">
                                    <label for="">شهر ها</label>
                                    <select
                                        class="valid col-xl-4 col-lg-4 col-12"
                                        id="Capacity"
                                        wire:model="req.city_id"
                                        name="Capacity">
                                        @foreach($cities as $c)
                                            <option value="{{$c->id}}">{{$c->title}}</option>
                                        @endforeach

                                    </select>
                                    @error('req.city_id')
                                    <p>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-100 d-flex justify-content-between">
                            <div class="textarea-box">
                                <label for="">توضیحات</label>
                                <textarea
                                    name=""
                                    wire:model.defer="req.description"

                                    class="border w-100 description text-justify"
                                    id=""
                                    placeholder="توضیحات اقامتگاه ( حداکثر 150 کارکتر ) "
                                ></textarea>
                                @error('req.description')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror

                            </div>
                            <div class="textarea-box">
                                <label for="">قوانین خود را تایپ کنید</label>
                                <textarea
                                    name=""
                                    wire:model.defer="req.rules.text"

                                    class="border w-100 description text-justify"
                                    id=""
                                    placeholder="قوانین اقامتگاه ( حداکثر 150 کارکتر ) "
                                ></textarea>
                                @error('req.rules.text')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror

                            </div>
                        </div>

                    </div>

                    <div class="card Content">
                        <div class="card-header HeaderContent">
                            <h6>آدرس ویلا</h6>
                        </div>
                        <div class="d-flex w-100 justify-content-between align-items-center p-3">
                            <div class="item-villa">
                                <label for="">نوع ویلا</label>
                                <select
                                    class="valid col-xl-4 col-lg-4 col-12 me-2"
                                    id="Capacity"
                                    wire:model="req.specifications.type"
                                    name="Capacity">
                                    <option value="null">-</option>
                                    @foreach(collect(config('vila.types')) as $type)
                                        <option value="{{$type['id']}}">{{$type['title']}}</option>
                                    @endforeach

                                </select>
                                @error('req.specifications.type')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="item-villa">
                                <label for="">چشم انداز</label>
                                <select
                                    class="valid col-xl-4 col-lg-4 col-12 me-2"
                                    id="Capacity"
                                    wire:model="req.specifications.view"
                                    name="Capacity">
                                    <option value="null">-</option>
                                    @foreach(collect(config('vila.views')) as $view)
                                        <option value="{{$view['id']}}">{{$view['title']}}</option>
                                    @endforeach

                                </select>
                                @error('req.specifications.view')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="SubContent p-2">
                            <div class="row no-gutters">


                                <div class="col-lg-12 col-md-12 mt-1 p-1">
              <textarea
                  name=""
                  class="border w-100"
                  id=""
                  wire:model.defer="req.address"
                  rows="5"
                  placeholder="آدرس کامل اقامتگاه ( آمل-خیابان 1- کوچه 2 -پلاک 110)"></textarea>
                                    @error('req.address')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card Content">
                            <div class="card-header HeaderContent">
                                <h6>ظرفیت ویلا</h6>
                            </div>
                            <div class="SubContent d-flex p-2">
                                <form class="form-row">
                                    <div class="col-lg-4 col-12 d-flex align-items-center Topic1 mb-1 mx-2">
                                        <div class="TopicIcon mx-2"><i class="fa fa-archway me-2"></i></div>
                                        <div class="SubTopic w-100">
                                            <div class="row d-flex align-items-center no-gutters">
                                                <div class="col-lg-5 p-1">
                                                    <label>متراژ زمین</label>
                                                </div>
                                                <div class="col-lg-7 p-1">
                                                    <input
                                                        type="number"
                                                        min="0"
                                                        wire:model.defer="req.land_area"
                                                    />
                                                </div>
                                                @error('req.land_rea')

                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="row d-flex align-items-center no-gutters">
                                                <div class="col-lg-5 p-1">
                                                    <label>متراژ بنا</label>
                                                </div>
                                                <div class="col-lg-7 p-1">
                                                    <input
                                                        type="number"
                                                        min="0"
                                                        wire:model.defer="req.building_area"
                                                    />
                                                    @error('req.building_area')
                                                    <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row d-flex align-items-center no-gutters">
                                                <div class="col-lg-5 p-1">
                                                    <label>تعداد تشک</label>
                                                </div>
                                                <div class="col-lg-7 p-1">

                                                    <select name="" id=""
                                                            wire:model.defer="req.mattress">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="6">7</option>
                                                        <option value="6">8</option>
                                                        <option value="6">9</option>
                                                    </select>
                                                </div>
                                                @error('req.mattress')

                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-12 d-flex align-items-center Topic1 mb-1 mx-2">
                                        <div class="TopicIcon mx-2"><i class="fa fa-users pr-2"></i></div>
                                        <div class="SubTopic w-100">
                                            <div class="row d-flex align-items-center no-gutters">
                                                <div class="col-lg-6 p-1">
                                                    <label class="ms-2">ظرفیت</label>
                                                </div>
                                                <div class="col-lg-6 p-1">
                                                    <select
                                                        class="valid"
                                                        id="Capacity"
                                                        wire:model.defer="req.max"

                                                        name="Capacity">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">24</option>
                                                        <option value="25">25</option>
                                                        <option value="26">26</option>
                                                        <option value="27">27</option>
                                                        <option value="28">28</option>
                                                        <option value="29">29</option>
                                                        <option value="30">30</option>
                                                    </select>
                                                    @error('req.max')
                                                    <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row d-flex align-items-center no-gutters">
                                                <div class="col-lg-5 p-1">
                                                    <label>تخت ۱ نفره</label>
                                                </div>
                                                <div class="col-lg-7 p-1">

                                                    <select name="" id=""
                                                            wire:model.defer="req.singleBed">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="6">7</option>
                                                        <option value="6">8</option>
                                                        <option value="6">9</option>
                                                    </select>
                                                </div>
                                                @error('req.singleBed')

                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="row d-flex align-items-center no-gutters">
                                                <div class="col-lg-5 p-1">
                                                    <label>تخت 2 نفره</label>
                                                </div>
                                                <div class="col-lg-7 p-1">

                                                    <select name="" id=""
                                                            wire:model.defer="req.twinBed">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="6">7</option>
                                                        <option value="6">8</option>
                                                        <option value="6">9</option>
                                                    </select>
                                                </div>
                                                @error('req.twinBed')

                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-12 d-flex align-items-center Topic1 mb-1 mx-2">
                                        <div class="TopicIcon mx-2"><i class="fa fa-bed pr-2"></i></div>
                                        <div class="SubTopic w-100">
                                            <div class="row d-flex align-items-center no-gutters">
                                                <div class="col-lg-5 p-1">
                                                    <label class="ms-2">تعداد اتاق</label>
                                                </div>
                                                <div class="col-lg-7 p-1">
                                                    <select
                                                        class="valid"
                                                        id="Rooms"
                                                        wire:model.defer="req.room_count"

                                                        name="Rooms">
                                                        <option>0</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                        <option>6</option>
                                                        <option>7</option>
                                                        <option>8</option>
                                                        <option>9</option>
                                                        <option>10</option>
                                                    </select>
                                                    @error('req.room_count')
                                                    <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card Content">
                            <div class="card-header HeaderContent">
                                <h6>با انتخاب تصاویر مناسب نمایش خوبی از اقامتگاهتان داشته باشید</h6>
                            </div>
                            <div class="SubContent p-2">
                                <div class="images text-center">
                                    <ul class="list-unstyled list-inline">

                                        @foreach($files->where('type' , 2) as $key => $_file)
                                            <li class="list-inline-item">
                                                <img src="{{ $_file['url'] }}" width="80" alt="{{ $_file['alt'] }}">
                                                <x-parnas.buttons.button type="button"
                                                                         class="btn btn-sm btn-danger"
                                                                         wire:click="deleteFile({{ $key }})"
                                                                         wire:loading.attr="disabled"
                                                                         wire:target="deleteFile">
                                                    <i class="fas fa-times"></i>
                                                </x-parnas.buttons.button>
                                                <x-parnas.buttons.button type="button"
                                                                         class="btn btn-sm btn-primary"
                                                                         wire:click="editFile({{ $key }})"
                                                                         wire:loading.attr="disabled"
                                                                         wire:target="deleteFile , editFile">
                                                    <i class="fas fa-edit"></i>
                                                </x-parnas.buttons.button>
                                            </li>
                                        @endforeach


                                        <div class="col-md-6">
                                            <x-parnas.inputs.file :file="$file['url']" model="file.url">
                                                @error('file.url')
                                                <p>{{ $message }}</p>
                                                @enderror
                                            </x-parnas.inputs.file>
                                            <div class="d-flex">
                                                <x-parnas.form-group class="col-xl-6 col-lg-6 col-12 mb-2">
                                                    <x-parnas.label class="mb-1" for="alt">متن جایگزین</x-parnas.label>
                                                    <x-parnas.inputs.text class="form-control form-control-sm" id="alt"
                                                                          wire:model.defer="file.alt"/>
                                                    @error('file.alt')
                                                    <p>{{ $message }}</p>
                                                    @enderror
                                                </x-parnas.form-group>
                                                <x-parnas.form-group class="col-xl-6 col-lg-6 col-12 mb-2">
                                                    <x-parnas.label class="mb-1" for="type">نوع</x-parnas.label>
                                                    <x-parnas.inputs.select class="form-select form-select-sm" id="type"
                                                                            wire:model.defer="file.type">
                                                        <x-parnas.inputs.option value="{{ null }}">انتخاب نوع
                                                        </x-parnas.inputs.option>
                                                        <x-parnas.inputs.option value="1">عکس شاخص
                                                        </x-parnas.inputs.option>
                                                        <x-parnas.inputs.option value="2">گالری</x-parnas.inputs.option>
                                                        <x-parnas.inputs.option value="3">فایل</x-parnas.inputs.option>
                                                    </x-parnas.inputs.select>
                                                    @error('file.type')
                                                    <p>{{ $message }}</p>
                                                    @enderror
                                                </x-parnas.form-group>
                                            </div>
                                            <x-parnas.form-group class="mb-2">
                                                <x-parnas.buttons.button
                                                    class="btn btn-success btn-sm col-xl-2 col-lg-2 col-6"
                                                    type="button" wire:click="upload"
                                                    wire:loading.attr="disabled" wire:target="upload"
                                                >
                                                    ثبت
                                                </x-parnas.buttons.button>
                                                <x-parnas.buttons.button
                                                    class="btn btn-danger btn-sm col-xl-2 col-lg-2 col-6"
                                                    type="button" wire:click="resetForm"
                                                    wire:loading.attr="disabled" wire:target="resetForm"
                                                >
                                                    لغو
                                                </x-parnas.buttons.button>
                                            </x-parnas.form-group>
                                        </div>


                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 ms-2">
                    <div class="Content">
                        <div class="card HeaderContent">
                            <div class="card-header">
                                <h6>وضعیت انتشار</h6>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-md-6 my-2 mx-2">
                                    <x-parnas.form-group class="input-group input-group-sm">
                                        <x-parnas.inputs.select class="form-select" wire:model.defer="req.status_id">
                                            <x-parnas.inputs.option value="{{ null }}">
                                                -
                                            </x-parnas.inputs.option>
                                            @foreach($statuses as $status)
                                                <x-parnas.inputs.option value="{{ $status->id }}">
                                                    {{ $status->label }}
                                                </x-parnas.inputs.option>
                                            @endforeach
                                        </x-parnas.inputs.select>

                                    </x-parnas.form-group>
                                    @error('req.status_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 my-2">
                        <div class="row col-xl-12 col-lg-12 col-12 d-flex justify-content-end">
                            <div class="p-1 col-lg-6 d-flex justify-content-center">
                                <button
                                    type="submit"
                                    class="SubmitButton text-center btn btn-success btn-sm">
                                    ثبت نهایی
                                </button>
                            </div>
                            <div class="p-1 col-lg-6 d-flex justify-content-center">
                                <button class="CancelButton text-center btn btn-danger btn-sm">
                                    بازگشت
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{--            <div class="col-lg-12">--}}
            {{--                <div class="Content">--}}
            {{--                    <div class="HeaderContent">--}}
            {{--                        <h3>آدرس روی نقشه</h3>--}}
            {{--                    </div>--}}
            {{--                    <div class="SubContent">--}}
            {{--                        <app-get-lat-long (latlng)="getLatlng($event)"></app-get-lat-long>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
    </div>
</form>

