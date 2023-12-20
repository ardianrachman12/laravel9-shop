@extends('layouts.app')

@section('title', 'Admin Profile')
@section('content')
    @include('layouts.alert')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="card-title">Profil Admin</h4>
        </div>
        <div class="card-body">
            <form action="/update-profile" method="post">
                @csrf
                <div class="form-group py-2">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" value="{{$data->name}}" name="name">
                </div>
                <div class="form-group py-2">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" value="{{$data->email}}" name="email">
                </div>
                <button type="submit" class="btn btn-warning me-2">Update Profile</button>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#changePasswordModal">Change Password</button>
            </form>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog"
    aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Ubah Password</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulir untuk mengganti password -->
                <form id="changePasswordForm" action="{{ route('updatePassword') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="current_password">Password Lama</label>
                        <input type="password" class="form-control" id="current_password"
                            name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">Password Baru</label>
                        <input type="password" class="form-control" id="new_password"
                            name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="confirm_password"
                            name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
