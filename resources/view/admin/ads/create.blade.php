@extends('admin.layouts.app')

@section('head-tag')
    <title>Create Ads</title>
@endsection


@section('content')
    <div class="content-header row">

    </div>
    <div class="content-body">

        <!-- Zero configuration table -->
        <section id="basic-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">آگهی</h4>
                            <span><a href="<?=route('admin.ads.index')?>" class="btn btn-success">بازگشت</a></span>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">

                                <form class="row" action="<?=route('admin.ads.store')?>" method="post"
                                      enctype="multipart/form-data">

                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="title">عنوان</label>
                                            <input name="title" type="text" id="title"
                                                   class="form-control <?=errorClass('title')?>"
                                                   placeholder="عنوان ..." value="<?=old('title')?>">
                                            <?=errorText('title')?>
                                        </fieldset>
                                    </div>


                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="image">تصویر</label>
                                            <input name="image" value="<?=old('image')?>" type="file" id="image"
                                                   class="form-control-file <?=errorClass('image')?>">
                                            <?=errorText('image')?>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="address">آدرس</label>
                                            <input name="address" value="<?=old('address')?>" type="text" id="address"
                                                   class="form-control <?=errorClass('address')?>"
                                                   placeholder="آدرس ...">
                                            <?=errorText('address')?>
                                        </fieldset>
                                    </div>


                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="floor">کف</label>
                                            <input name="floor" value="<?=old('floor')?>" type="text" id="floor"
                                                   class="form-control <?=errorClass('floor')?>"
                                                   placeholder="کف ...">
                                            <?=errorText('floor')?>
                                        </fieldset>
                                    </div>


                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="year">سال ساخت</label>
                                            <input name="year" value="<?=old('year')?>" type="text" id="year"
                                                   class="form-control <?=errorClass('year')?>"
                                                   placeholder="سال ساخت ...">
                                            <?=errorText('year')?>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="amount">قیمت</label>
                                            <input name="amount" value="<?=old('amount')?>" type="text" id="amount"
                                                   class="form-control <?=errorClass('amount')?>"
                                                   placeholder="قیمت ...">
                                            <?=errorText('amount')?>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="area">متراژ</label>
                                            <input name="area" value="<?=old('area')?>" type="text" id="area"
                                                   class="form-control <?=errorClass('area')?>"
                                                   placeholder="متراژ ...">
                                            <?=errorText('area')?>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="room">اتاق</label>
                                            <input name="room" value="<?=old('room')?>" type="text" id="room"
                                                   class="form-control <?=errorClass('room')?>"
                                                   placeholder="تعداد اتاق ...">
                                            <?=errorText('room')?>
                                        </fieldset>
                                    </div>


                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="tag">تگ</label>
                                            <input name="tag" value="<?=old('tag')?>" type="text" id="tag"
                                                   class="form-control <?=errorClass('tag')?>"
                                                   placeholder="تگ ...">
                                            <?=errorText('tag')?>
                                        </fieldset>
                                    </div>


                                    <div class="col-md-12">
                                        <section class="form-group">
                                            <label for="description">متن</label>
                                            <textarea class="form-control <?=errorClass('description')?>"
                                                      id="description" rows="5" name="description"
                                                      placeholder="متن ..."><?=old('description')?></textarea>
                                            <?=errorText('description')?>
                                        </section>

                                    </div>


                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <div class="form-group">
                                                <label for="storeroom">انبار</label>
                                                <select name="storeroom"
                                                        class="select2 form-control <?=errorClass('storeroom')?>">
                                                    <option value="0" <?=old('storeroom') == 0 ? 'selected' : ''?>>
                                                        ندارد
                                                    </option>
                                                    <option value="1" <?=old('storeroom') == 1 ? 'selected' : ''?>>
                                                        دارد
                                                    </option>
                                                </select>
                                                <?=errorText('storeroom')?>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <div class="form-group">
                                                <label for="balcony">بالکن</label>
                                                <select name="balcony"
                                                        class="select2 form-control <?=errorClass('balcony')?>">
                                                    <option value="0" <?=old('balcony') == 0 ? 'selected' : ''?>>ندارد
                                                    </option>
                                                    <option value="1" <?=old('balcony') == 1 ? 'selected' : ''?>>دارد
                                                    </option>
                                                </select>
                                                <?=errorText('balcony')?>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <div class="form-group">
                                                <label for="toilet">توالت</label>
                                                <select name="toilet"
                                                        class="select2 form-control <?=errorClass('toilet')?>">
                                                    <option value="ایرانی" <?=old('toilet') == "ایرانی" ? 'selected' : ''?>>
                                                        ایرانی
                                                    </option>
                                                    <option value="فرنگی" <?=old('toilet') == "فرنگی" ? 'selected' : ''?>>
                                                        فرنگی
                                                    </option>
                                                    <option value="ایرانی و فرنگی" <?=old('toilet') == "ایرانی و فرنگی" ? 'selected' : ''?>>
                                                        ایرانی و فرنگی
                                                    </option>
                                                </select>
                                                <?=errorText('toilet')?>
                                            </div>
                                        </fieldset>
                                    </div>


                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <div class="form-group">
                                                <label for="sell_status">نوع آگهی</label>
                                                <select name="sell_status"
                                                        class="select2 form-control <?=errorClass('sell_status')?>">
                                                    <option value="0" <?=old('sell_status') == 0 ? 'selected' : ''?>>
                                                        خرید
                                                    </option>
                                                    <option value="1" <?=old('sell_status') == 1 ? 'selected' : ''?>>
                                                        اجاره
                                                    </option>
                                                </select>
                                                <?=errorText('sell_status')?>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <div class="form-group">
                                                <label for="type">نوع ملک</label>
                                                <select name="type"
                                                        class="select2 form-control <?=errorClass('type')?>">
                                                    <option value="0" <?=old('type') == 0 ? 'selected' : ''?>>آپارتمان
                                                    </option>
                                                    <option value="1" <?=old('type') == 1 ? 'selected' : ''?>>ویلایی
                                                    </option>
                                                    <option value="2" <?=old('type') == 2 ? 'selected' : ''?>>زمین
                                                    </option>
                                                    <option value="3" <?=old('type') == 3 ? 'selected' : ''?>>سوله
                                                    </option>
                                                </select>
                                                <?=errorText('type')?>
                                            </div>
                                        </fieldset>
                                    </div>


                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <div class="form-group">
                                                <label for="parking">پارکینگ</label>
                                                <select name="parking"
                                                        class="select2 form-control <?=errorClass('parking')?>">
                                                    <option value="0" <?=old('parking') == 0 ? 'selected' : ''?>>ندارد
                                                    </option>
                                                    <option value="1" <?=old('parking') == 1 ? 'selected' : ''?>>دارد
                                                    </option>
                                                </select>
                                                <?=errorText('parking')?>
                                            </div>
                                        </fieldset>
                                    </div>


                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <div class="form-group">
                                                <label for="cat_id">دسته</label>
                                                <select name="cat_id"
                                                        class="select2 form-control <?=errorClass('cat_id')?>">
                                                    <?php foreach ($categories as $category){ ?>
                                                    <option value="<?=$category->id?>" <?=old('cat_id') == $category->id ? 'selected' : ''?> ><?=$category->name?></option>
                                                    <?php } ?>
                                                </select>
                                                <?=errorText('cat_id')?>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <section class="form-group">
                                            <button type="submit" class="btn btn-primary">ایجاد</button>
                                        </section>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    </div>
@endsection


@section('scripts')
    <script src="<?=asset('ckeditor/ckeditor.js')?>"></script>
    <script type="text/javascript">
        CKEDITOR.replace('description')
    </script>
@endsection



