@extends('layouts.auth.master')

@section('title', 'Notifications')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row" id="notifications-timeline">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        @if (count($data) > 0)
                            @if ($notification->unreadCount > 0)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="small text-muted unread-noti-count mb-0"><em>{{$notification->unreadCount}} unread {{($notification->unreadCount == 1 ? 'notification' : 'notifications')}}</em></p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button class="btn btn-flat btn-outline-danger btn-xs mark-all-read-btn" onclick="markNotificationRead()">Mark all as read</button>
                                </div>
                            </div>
                            @endif
                        @endif

                        @forelse ($data as $noti)
                        <a href="javascript: void(0)" class="notification-single" onclick="readNotification('{{$noti->id}}', '{{($noti->route ? route($noti->route) : '')}}')">
                            <div class="callout callout-sm {{($noti->read_flag == 0 ? 'callout-dark' : '')}}">
                                <h6 class="heading">{{$noti->title}}</h6>
                                <p class="description">{{$noti->message}}</p>
                                <p class="timing">20 hours ago</p>
                            </div>
                        </a>
                        @empty
                        <p class="small text-muted text-center my-5">No notifications yet</p>
                        @endforelse

                        <div class="pagination-view">
                            {{$data->links();}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>

    </script>
@endsection