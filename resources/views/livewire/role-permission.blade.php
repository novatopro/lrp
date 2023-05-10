<div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarRolePermission" aria-controls="navbarRolePermission" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarRolePermission">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                        wire:model="search">
                </div>
            </div>
        </nav>
        @if ($search)
            <div class="alert alert-info">
                <h3>Searching: {{ $search }}</h3>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $item)
                    <p class="mb-0">{{ $item }}</p>
                @endforeach
            </div>
        @endif
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="{{ $role->id ? 'sticky-top' : '' }}">
            <h3>{{ $roletitle }}</h3>
            <input type="text" wire:model="role.name" placeholder="Role name" class="form-control {{$errors->has('role.name')?'is-invalid':''}}">
            <input type="text" wire:model="role.slug" readonly placeholder="Role slug" class="form-control {{$errors->has('role.slug')?'is-invalid':''}}">
            <button type="button" wire:click="resetInputs" class="btn btn-secondary">Cancel</button>
            <button type="button" wire:click="saverole" class="btn btn-success">Save Role</button>
            @if ($role->id)
                <div class="row">
                    <div class="col-md-6">
                        <h4>Asigned permissions</h4>
                        @forelse ($role->permissions as $item)
                            <button type="button" class="btn btn-danger" wire:click="removePermissionFromRole({{$item->id}})">{{$item->name}}</button>
                        @empty
                            <p>No permissions asigned</p>
                        @endforelse
                    </div>
                    <div class="col-md-6">
                        <h4>Asign permissions</h4>
                        @forelse ($permissions->whereNotIn('id',$role->permissions->pluck('id')->toArray()) as $item)
                            <button type="button" class="btn btn-success" wire:click="addPermissionToRole({{$item->id}})">{{$item->name}}</button>
                        @empty
                            <p>No permissions created / No permissions to asign</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
        <div class="{{ $permission->id ? 'sticky-top' : '' }}">
            <h3>{{ $permissiontitle }}</h3>
            <input type="text" wire:model="permission.name" placeholder="Permission name" class="form-control {{$errors->has('permission.name')?'is-invalid':''}}">
            <input type="text" wire:model="permission.slug" readonly placeholder="Permission slug" class="form-control {{$errors->has('permission.slug')?'is-invalid':''}}">
            <textarea wire:model="permission.description" placeholder="Permission description" class="w-100 mt-2 form-control {{$errors->has('permission.description')?'is-invalid':''}}"></textarea>
            <button type="button" wire:click="resetInputs" class="btn btn-secondary">Cancel</button>
            <button type="button" wire:click="savepermission" class="btn btn-success">Save Permission</button>
        </div>

        <div>
            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>Role Name</th>
                        <th>Role Slug</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->slug }}</td>
                            <td>{{ implode(', ', $item->permissions->pluck('name')->toArray()) }}</td>
                            <td>
                                <button type="button" class="btn btn-warning"
                                    wire:click="editrole({{ $item->id }})">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>Permission Name</th>
                        <th>Permission Slug</th>
                        <th>Permission Description</th>
                        <th>Roles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->slug }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ implode(', ', $item->roles->pluck('name')->toArray()) }}</td>
                            <td>
                                <button type="button" class="btn btn-warning"
                                    wire:click="editpermission({{ $item->id }})">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</div>
