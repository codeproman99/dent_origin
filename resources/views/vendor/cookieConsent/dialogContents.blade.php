
<style>
.cookie-bar {
  padding:20px;
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  margin: 0 !important;
  z-index: 999;
  opacity: 1;
  border-radius: 0;
  color: #ecf0f1;
  background: #212327;
}
</style>

<div class="js-cookie-consent cookie-consent cookie-bar">
    <span class="cookie-consent__message">
        {!! trans('cookieConsent::texts.message') !!}
        <a href="{!! trans('cookieConsent::texts.link') !!}">Altre Info</a>
    </span>
    &nbsp;
    <button class="js-cookie-consent-agree cookie-consent__agree btn btn-primary btn-sm acceptcookies">
        {{ trans('cookieConsent::texts.agree') }}
    </button>

</div>
