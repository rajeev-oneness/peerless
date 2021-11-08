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
                                    <button class="btn btn-flat btn-outline-danger btn-xs mark-all-read-btn" onclick="markAllNotificationRead()"><i class="fas fa-tag fa-rotate-90"></i> Mark all as read</button>
                                </div>
                            </div>
                            @endif
                        @endif

                        @forelse ($data as $noti)
                        <a href="javascript: void(0)" class="notification-single" onclick="readNotification('{{$noti->id}}', '{{($noti->route ? route($noti->route) : '')}}')">
                            <div class="callout callout-sm {{($noti->read_flag == 0 ? 'callout-dark' : '')}}">
                                <h6 class="heading">{{$noti->title}}</h6>
                                <p class="description">{{$noti->message}}</p>
                                <p class="timing">{{\carbon\carbon::parse($noti->created_at)->diffForHumans()}}</p>
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
    function markAllNotificationRead() {
        $.ajax({
            url : '{{route("user.notification.mark.readAll")}}',
            method : 'POST',
            data : {'_token' : '{{csrf_token()}}'},
            beforeSend : function() {
                $('#notifications-timeline .mark-all-read-btn').prop('disabled', true).html('<i class="fas fa-sync-alt"></i> Please wait');
            },
            success : function(result) {
                $('#notifications-timeline .notification-single .callout').removeClass('callout-dark');
                $('#notifications-timeline .unread-noti-count').text('');
                $('#notifications-timeline .mark-all-read-btn').removeClass('btn-outline-danger').addClass('btn-success').html('<i class="fas fa-check"></i> All notifications marked as read');
            }
        });
    }
    </script>
@endsection