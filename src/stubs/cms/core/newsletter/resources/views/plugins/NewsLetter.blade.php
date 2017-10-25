<style>
     .home-newsletter .single {
        max-width: 650px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        z-index: 2; }
    .home-newsletter .single h2 {
        font-size: 22px;
        color: white;
        text-transform: uppercase;
        margin-bottom: 40px; }
    .home-newsletter .single .form-control {
        height: 35px;
        background: rgba(255, 255, 255, 0.6);
        border-color: transparent;
       // border-radius: 20px 0 0 20px;
    }
    .home-newsletter .single .form-control:focus {
        box-shadow: none;
        border-color: #243c4f; }
    .home-newsletter .single .btn {
        min-height: 35px;
        border-radius: 0 20px 20px 0;
        background: #243c4f;
        color: #fff;
    }
</style>
<div class="row home-newsletter">
    <div class="col-xs-12 single">
        {!! Form::open(array('url'=>array('add-subscriber'))) !!}
            <div class="input-group">
                <input name="email" type="email" class="form-control" placeholder="Enter your email">
                <span class="input-group-btn">
                    <button class="btn btn-theme" type="submit">Subscribe</button>
                 </span>
            </div>
        {!! Form::close() !!}
    </div>
</div>