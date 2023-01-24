<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Get Posts') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!--Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">

    <main class="py-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session()->has('Add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('Add') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session()->has('delete'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('delete') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session()->has('edit'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('edit') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
    @endif

    <!-- Menu Section Start -->
        <section id="food-menu">
            <div class="container">
                <header class="section-header" style="text-align: center">
                    <h3>Posts List</h3>
                    <div style="display: inline">
                    <a class="btn btn-primary" href="{{ route('home') }}" style="float: left;text-decoration:none;"> Back</a>                    </div>
                    <a href="#newpost" data-toggle="modal"><button  class="btn btn-primary" style="display: block;float: right;margin-right: 20px; margin-bottom: 20px;text-decoration:none;"> + Add New Post </button></a>
                </header>

                <br>
                <!---add new post -->
                <div class="modal" tabindex="-1" role="dialog" id="newpost">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Post</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('posts.store')}}"method="post" >
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Username</label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        <option value="" selected disabled> --Select Username--</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Post Title</label>
                                    <input type="text" class="form-control" id="title"name="title" placeholder="Enter Post Title">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Post Text</label>
                                    <textarea class="form-control" id="text"name="text" rows="3"placeholder="Enter Post Text"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit"  class="btn btn-success">Add && Save</button>
                                    <button type="button"  class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Menu Section End-->
        <!-- Cart Section Start -->
        <section id="cart" style="text-align: center">
            <div class="container">
                <table class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Post Title</th>
                        <th scope="col">Text Title</th>
                        <th scope="col">Image</th>
                        <th scope="col">Delete/Edit</th>
                    </tr>

                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach ($posts as $x)
                        <?php $i++; ?>
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $x->user->name }}</td>
                            <td>{{ $x->title }}</td>
                            <td>{{ $x->text }}</td>
                            <td><img src="img/{{$x->image}}"></td>
                            <td>
                                <a data-id="{{ $x->id }}"
                                   data-user_name="{{ $x->user->name }}"
                                   data-title="{{ $x->title }}"
                                   data-text="{{ $x->text }}"
                                   data-toggle="modal"
                                   href="#editpost" title="Edit"><button class="btn-success">Edit</button>
                                </a>
                                <a data-id="{{ $x->id }}"
                                   data-title="{{ $x->title }}"
                                   data-toggle="modal" href="#deletepost" title="Delete"><button class="btn-danger">Delete</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>
        <!--edit post -->
        <div class="modal" tabindex="-1" role="dialog" id="editpost">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times</span>
                        </button>
                    </div>
                    <form action="{{route('posts.update',$posts[0]->id)}}"method="post" >
                        {{ method_field('patch') }}
                        {{csrf_field()}}
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="">
                            <label for="exampleFormControlInput1">Username</label>
                            <input type="text" class="form-control" id="user_name"name="user_name" placeholder="Enter Category Name" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Post Title</label>
                            <input type="text" class="form-control" id="title"name="title" placeholder="Enter Post Title">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Post Text</label>
                            <textarea class="form-control" id="text"name="text" rows="3"placeholder="Enter Post Text"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn-success">Save changes</button>
                            <button type="button" class="btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- delete post -->
        <div class="modal" tabindex="-1" role="dialog" id="deletepost">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('posts.destroy',$posts[0]->id)}}"method="post" >
                        {{ method_field('delete') }}
                        {{csrf_field()}}
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="">
                            <label for="exampleFormControlInput1">Post Title</label>
                            <input type="text" class="form-control" id="title"name="title" placeholder="Enter Post Title">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn-success">Confirm Delete</button>
                            <button type="button" class="btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>
</div>
<!--Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script></script>
<script>
    $('#editpost').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var title = button.data('title')
        var text = button.data('text')
        var user_name = button.data('user_name')
        var modal = $(this)
        modal.find('.modal-content .form-group #id').val(id);
        modal.find('.modal-content .form-group #title').val(title);
        modal.find('.modal-content .form-group #text').val(text);
        modal.find('.modal-content .form-group #user_name').val(user_name);
    });
    $('#deletepost').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var title = button.data('title')
        var modal = $(this)
        modal.find('.modal-content .form-group #id').val(id);
        modal.find('.modal-content .form-group #title').val(title);
    });
</script>
</body>
</html>


