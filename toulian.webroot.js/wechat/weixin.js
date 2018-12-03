wx.config({
    debug: false,
    appId: T.weixin.appId,
    timestamp: T.weixin.timestamp,
    nonceStr: T.weixin.nonceStr,
    signature: T.weixin.signature,
    jsApiList: [
        // 所有要调用的 API 都要加到这个列表中
        'chooseWXPay',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'onMenuShareQZone',
        'scanQRCode'
    ]
});
wx.ready(function () {
    // 在这里调用 API
});
wx.error(function (res) {
    // 通过error接口处理失败验证
    alert(res.errMsg);
});