<!DOCTYPE html>
<html lang="en">
@include('layout.head')

<body>
    <div class="container-scroller">

        @include('layout.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('layout.aside')

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    @include('layout.footer')
</body>

</html>
