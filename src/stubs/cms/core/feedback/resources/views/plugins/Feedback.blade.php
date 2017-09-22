{!!Cms::script('js/jquery.feedBackBox.js')!!}
{!!Cms::style('css/jquery.feedBackBox.css')!!}
<script type="text/javascript">
    $(document).ready(function () {
        $('#feedback').feedBackBox({
            title: 'Feedback',
            titleMessage: 'Please feel free to leave us feedback.',
            userName: '',
            isUsernameEnabled: true,
            token : "{{ csrf_token() }}",
            message: '',
            ajaxUrl: '{{route("do_feedback")}}',
            successMessage: 'Thank your for your feedback.',
            errorMessage: 'Something wen\'t wrong!'
        });
    });
</script>

<div id="feedback"></div>

