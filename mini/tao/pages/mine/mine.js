// const util = require('../../utils/util.js');
var app = getApp();
const util = require('../../utils/util');

Page({
    data: {
        info: {}
    },
    /**
     * 组件的方法列表
     */
    toMyOrder() {
        wx.navigateTo({
            url: "/pages/myOrder/myOrder",

        })
    },
    toMyAward() {
        wx.navigateTo({
            url: "/pages/myAward/myAward",

        })
    },
 
    toMyProfit() { 
        wx.setStorageSync('log_type', 2);//2 我的收益
        wx.navigateTo({
            url: "/pages/myProfit/myProfit",
        })
    },

    toInviteLog() { 
        wx.setStorageSync('log_type', 1);//1 邀请用户记录
        wx.navigateTo({
            url: "/pages/myProfit/myProfit",
        })
    },


    toAgreement(){
        wx.navigateTo({
            url: "/pages/Agreement/Agreement",
        })

    },

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
    }
})