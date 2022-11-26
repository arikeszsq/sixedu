// pages/myAward/myAward.js
const app = getApp();

Page({

    /**
     * 页面的初始数据
     */
    data: {
        //别表数据
        info: [],
        //当前打开的
        currentIndex: 0
    },
    changeScrollView(e) {
        //改变当前值
        this.setData({
            currentIndex: e.currentTarget.dataset.index
        })
    },
    bindchangeSwiper(e) {
        this.setData({
            currentIndex: e.detail.current
        })
    },
    //info数据的获取
    getAwardlist: function (activity_id) {
        app.apiRequest({
            url: '/award/lists',
            method: 'get',
            data: {
            },
            success: res => {
                var that = this;
                console.log(res.data.response, "s")
                that.setData({
                    info: res.data.response
                })
            }
        });
    },
    /**
     * 生命周期函数--监听页面加载
     */
    onLoad(options) {
        this.getAwardlist();
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