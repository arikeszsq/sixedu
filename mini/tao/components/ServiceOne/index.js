const app = getApp();

// components/Service/Service.js
Component({
    /**
     * 组件的属性列表
     */
    properties: {
    },

    /**
     * 组件的初始数据
     */
    data: {
        isShow: false,

    },

    computed: {
    },
    /**
     * 组件的方法列表
     */


    methods: {

        //我的页面跳转
        navigatorMy() {
            wx.navigateTo({
                url: '/pages/mine/mine',
            })
        },
        //开团
        toCourseOne(e) {
            wx.setStorageSync('type', 1)
            this.triggerEvent("toCourseOne")
        },
        //单独购买
        toCourseTwo(e) {
            wx.setStorageSync('type', 2)
            this.triggerEvent("toCourseTwo")
        },
        //弹出客服页面
        serviceDialogue() {
            this.getKeFuDetail();
            this.setData({
                isShow: true
            })
        },
        closedHanler() {
            this.setData({
                isShow: false
            })
        },
        getKeFuDetail() {
            var that = this;
            app.apiRequest({
                url: '/basic/settings',
                method: 'get',
                data: {
                },
                success: res => {
                    that.setData({
                        kf_name: res.data.response.kf_name,
                        mobile: res.data.response.mobile,
                        pic: res.data.response.pic
                    })
                }
            });
        },
    }
})
