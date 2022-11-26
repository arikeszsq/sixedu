// pages/myProfit/myProfit.js
const app = getApp();
Page({

    /**
     * 页面的初始数据
     */
    data: {
        info:[]
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad(options) {
        this.getLogList();
    },

    getLogList(){
        app.apiRequest({
            url: '/log/list',
            method: 'get',
            data: {
                'log_type':wx.getStorageSync('log_type')
            },
            success: res => {
                var that = this;
                that.setData({
                    info: res.data.response
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