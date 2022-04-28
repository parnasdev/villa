<div>
    @if (session()->has('message'))
        <x-parnas.alert color="{{ session('message')['icon'] }}">
            {{ session('message')['title'] }}
        </x-parnas.alert>
    @endif
{{--        <div class="d-flex justify-content-between">--}}
{{--            <x-parnas.form-group class="mb-2 w-25">--}}
{{--                <x-parnas.label class="mb-2">عملیات انتخابی ها</x-parnas.label>--}}
{{--                <x-parnas.inputs.select class="form-select" wire:model="action" wire:change="actionMessage">--}}
{{--                    <x-parnas.inputs.option value="0">--}}
{{--                        ---}}
{{--                    </x-parnas.inputs.option>--}}
{{--                    <x-parnas.inputs.option value="1">--}}
{{--                        حذف انتخابی ها--}}
{{--                    </x-parnas.inputs.option>--}}
{{--                    @if($trash)--}}
{{--                        <x-parnas.inputs.option value="2">--}}
{{--                            بازگردانی انتخابی ها--}}
{{--                        </x-parnas.inputs.option>--}}
{{--                    @endif--}}
{{--                </x-parnas.inputs.select>--}}
{{--            </x-parnas.form-group>--}}
{{--            <div>--}}
{{--                <x-parnas.buttons.button class="btn btn-sm btn-outline-{{ $trash ? 'primary' : 'danger' }}" wire:click="showTrash">--}}
{{--                    <i class="fas fa-{{ $trash ? 'eye' : 'trash'}}"></i>{{ $trash ? ' نمایش لیست' : ' نمایش سطل آشغال' }}--}}
{{--                </x-parnas.buttons.button>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="table-responsive position-relative"
             x-data="{
            ordering(col) {
                if  (col === $wire.get('orderCol')) {
                    @this.set('ordering' , $wire.get('ordering') === 'desc' ? 'asc' : 'desc')
                }

                @this.set('orderCol' , col)
            }
        }">
            <x-parnas.spinners :full="true" wire:loading
                               wire:target="status , gotoPage , previousPage , nextPage , changeStatus , selectedAction , delete , forceDelete , selected"/>
            <table class="table table-bordered caption-top">
                <caption>
                    <x-parnas.form-group class="position-relative">
                    <div class="position-relative">
                        <input placeholder="جست و جو" wire:model="q" class="form-control">
                        <span wire:loading="wire:loading" wire:target="q" class="spinner-border spinner-border-sm me-2 position-absolute end-0 bottom-50" role="status" aria-hidden="true"></span>
                    </div>
                    </x-parnas.form-group>
                    <div class="d-flex justify-content-around mt-1">
                        <x-parnas.form-group class="form-check">
                            <x-parnas.inputs.text class="form-check-input" type="radio" :value="0" id="0"
                                                  wire:model="status"/>
                            <x-parnas.label class="form-check-label" for="0">
                                همه
                            </x-parnas.label>
                        </x-parnas.form-group>
                        @foreach($statuses as $status)
                            <x-parnas.form-group class="form-check">
                                <x-parnas.inputs.text class="form-check-input" type="radio" :value="$status->id"
                                                      id="status_{{ $status->id }}" wire:model="status"/>
                                <x-parnas.label class="form-check-label" for="status_{{ $status->id }}">
                                    {{ $status->label }}
                                </x-parnas.label>
                            </x-parnas.form-group>
                        @endforeach
                    </div>
                </caption>
                <thead>
                <tr>
                    <th>
                        انتخاب
                    </th>
                    <th @click="ordering('id')">
                        شناسه
                    </th>
                    <th @click="ordering('title')">نام ویلا</th>
                    <th @click="ordering('created_at')">تاریخ ایجاد</th>
                    <th @click="ordering('status_id')">وضعیت</th>
                    <th>اقدام</th>
                </tr>
                </thead>
                <tbody>

                @forelse($villas as $villa)
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model.defer="selected" value="4" id="4">
                                <label class="form-check-label" for="4"></label>
                            </div>
                        </td>
                        <td>{{ $villa->id }}</td>

                        <td>
                            <a href="{{ $villa->path() }}">{{ $villa->title }}</a>
                        </td>
                        <td>
                            {{ jdate($villa->created_at)->format('Y-m-d H:i') }}
                        </td>

                        <td x-data="">
                            <x-parnas.inputs.select class="form-select"
                                                    @change="$wire.changeStatus({{ $villa->id }} , $el.value)">
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}" {{ $villa->status_id == $status->id ? 'selected' : '' }}>
                                        {{ $status->label }}
                                    </option>
                                @endforeach
                            </x-parnas.inputs.select>
                        </td>
                        <td>
                            <x-parnas.buttons.link class="btn btn-sm btn-primary" href="/admin/villa/priceManagement/{{$villa->id}}">
                                <i class="fas fa-info"></i>
                            </x-parnas.buttons.link>
                            <x-parnas.buttons.link class="btn btn-sm btn-primary" href="/admin/villa/edit/{{$villa->id}}">
                                <i class="fas fa-edit"></i>
                            </x-parnas.buttons.link>
{{--                            <x-parnas.buttons.button class="btn btn-sm btn-danger" wire:click="message({{ $villa->id }} , {{ $trash }})">--}}
{{--                                <i class="fas fa-trash"></i>--}}
{{--                            </x-parnas.buttons.button>--}}
{{--                            @if($villa->trashed())--}}
{{--                                <x-parnas.buttons.button class="btn btn-sm btn-success" wire:click="message({{ $villa->id }} , {{ $trash }} , true)">--}}
{{--                                    <i class="fas fa-redo-alt"></i>--}}
{{--                                </x-parnas.buttons.button>--}}
{{--                            @endif--}}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">موردی یافت نشد!!!</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
{{--            <div class="d-flex justify-content-between">--}}
{{--                <x-parnas.form-group class="mb-2 w-25">--}}
{{--                    <x-parnas.label class="mb-2">عملیات انتخابی ها</x-parnas.label>--}}
{{--                    <x-parnas.inputs.select class="form-select" wire:model="action" wire:change="actionMessage">--}}
{{--                        <x-parnas.inputs.option value="0">--}}
{{--                            ---}}
{{--                        </x-parnas.inputs.option>--}}
{{--                        <x-parnas.inputs.option value="1">--}}
{{--                            حذف انتخابی ها--}}
{{--                        </x-parnas.inputs.option>--}}
{{--                        @if($trash)--}}
{{--                            <x-parnas.inputs.option value="2">--}}
{{--                                بازگردانی انتخابی ها--}}
{{--                            </x-parnas.inputs.option>--}}
{{--                        @endif--}}
{{--                    </x-parnas.inputs.select>--}}
{{--                </x-parnas.form-group>--}}
{{--                {{$villas->links() }}--}}
{{--            </div>--}}
        </div>

</div>
