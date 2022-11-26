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
                        pic :res.data.response.pic
                    })
                }
            });
        },
    }
})
