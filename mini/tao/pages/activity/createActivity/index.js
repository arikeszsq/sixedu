var app = getApp();

// pages/activity/createActivity/index.js
Page({

    /**
     * 页面的初始数据
     */
    data: {
        info: ''
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad(options) {
        this.getBasicInfo();
    },

    getBasicInfo() {
        var that = this;
        app.apiRequest({
            url: '/basic/settings',
            method: 'get',
            data: {
            },
            success: res => {
                that.setData({
                    'info': res.data.response
                });
            }
        });
    },

    createNewActivity(e) {
        var activity_id = wx.getStorageSync('activity_id');
        var username = e.detail.value.username;
        var mobile = e.detail.value.mobile;
        var shop_name = e.detail.value.shop_name;
        if (username && mobile && shop_name) {
            this.setData({
                isShowDislogue: false
            }),
                wx.showToast({
                    title: '加载中',
                    icon: 'loading', //图标，支持"success"、"loading"
                }),
                //信息完整发起支付
                app.apiRequest({
                    url: '/activity/web-create',
                    method: 'post',
                    data: {
                        'activity_id': activity_id,
                        'shop_name': shop_name,
                        'contacter': username,
                        'mobile': mobile
                    },
                    success: res => {
                        wx.showToast({
                            title: '添加成功'
                        });
                        // setTimeout(wx.navigateBack({
                        //     delta: 0
                        // }), 5000)
                        // wx.navigateBack({
                        //   delta: 0
                        // })
                    }
                });
        } else {
            wx.showToast({
                title: '请填完整信息',
                icon: "error"
            })
        }
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