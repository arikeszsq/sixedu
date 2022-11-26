const app = getApp();
// components/Service/Service.js
Component({
    /**
     * 组件的属性列表
     */
    properties: {

        oriPrice: String,
        realPrice: String
    },

    /**
     * 组件的初始数据
     */
    data: {
        isShow: false,
        kf_name: '',
        mobile: "15062332900",
        pic: "https://zsq.a-poor.com/uploads/images/8376382dd5344e8ee76cda8ac697c909.png"
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
        //单独购买
        toCourseOne(e) {
            wx.setStorageSync('group_id', 0);
            wx.setStorageSync('type', 2);
            wx.setStorageSync('buy_method', 2);//购买方式 1 表示直接购买，购买方式 2，参团购买，这里是开团，参团的话，直接跳转到团列表页选择团
            this.triggerEvent("toCourseOne", e.currentTarget.dataset.type)
        },
        //开团
        toCourseTwo(e) {
            wx.setStorageSync('group_id', 0);
            wx.setStorageSync('type', 1);
            wx.setStorageSync('buy_method', 2);//购买方式 1 表示直接购买，购买方式 2，参团购买，这里是开团，参团的话，直接跳转到团列表页选择团
            this.triggerEvent("toCourseTwo", e.currentTarget.dataset.type)
        },
        //弹出客服页面
        serviceDialogue() {
            this.getKeFuDetail();
            console.log("点击了吗")
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
                        pic :res.data.response.pic
                    })
                }
            });
        },
    }
})
