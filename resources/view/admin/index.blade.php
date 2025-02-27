@extends('admin.layouts.app')

@section('head-tag')
    <title>Panel</title>
@endsection


@section('content')
    <div class="content-body">
        <section id="dashboard-analytics">
            <div class="row">
                <div class="col-md-12">
                    <div class="card bg-analytics text-white">
                        <div class="card-content">
                            <div class="card-body text-center">
                                <img src="<?=asset("admin-assets/images/elements/decore-left.png")?>" class="img-left"
                                     alt=" card-img-left">
                                <img src="<?=asset("admin-assets/images/elements/decore-right.png")?>" class="img-right"
                                     alt=" card-img-right">
                                <div class="avatar avatar-xl bg-primary shadow mt-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-award white font-large-1"></i>
                                    </div>
                                </div>
                                <div class="text-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection