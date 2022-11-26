// pages/activity/one/index.js
var app = getApp();
Page({

    /**
     * 页面的初始数据
     */
    data: {
        info: {}
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
        this.getUserInfo();
    },
    getUserInfo: function () {
        app.apiRequest({
            url: '/user/info',
            method: 'get',
            data: {
            },
            success: res => {
                var that = this;
                console.log(res.data.response, "d");
                that.setData({
                    info: res.data.response,
                })
            }
        });
    },


    /**
     * 生命周期函数--监听页面初次渲染完成
     */
    onReady() {

},

/**
 * 生命周期函数--监听页面显示
 */
onShow() {

},

/**
 * 生命周期函数--监听页面隐藏
 */
onHide() {

},

/**
 * 生命周期函数--监听页面卸载
 */
onUnload() {

},

/**
 * 页面相关事件处理函数--监听用户下拉动作
 */
onPullDownRefresh() {

},

/**
 * 页面上拉触底事件的处理函数
 */
onReachBottom() {

},

/**
 * 用户点击右上角分享
 */
onShareAppMessage() {

}
})