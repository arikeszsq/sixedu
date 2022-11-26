// pages/activity/many/index.js
const app = getApp();
var util = require('../../../utils/util');
Page({
    /**
     * 页面的初始数据
     */
    data: {
        // 页面总高度将会放在这里
        // scroll-view的高度
        isShowDialogue: true,
        height: 0,
        //详情所有信息
        info: {},
        oriPrice: "0",
        realPrice: "0",
        oriPriceAfter: '00',
        price: {
            name: "xxxxxxxx1",
            id: 1
        },
        //家的地址
        adressObj: {
            latitude: '',
            longitude: '',
            name: '',
        },

        //活动分类
        ActiveBarList: [{ name: "活动详情", id: "1" }, { name: "机构详情", id: "2" }, { name: "奖励详情", id: "3" }],
        activeIndex: 0,
        videoIndex: 0,
        //当前播放的视频
        indexCurrent: "video1",
        nowDate:''
    },



    //切换视频时候设置视频暂停：整体思路data里面indexCurrent,默认值是第一个视频，当我们切换的时候，就会重新给一个id，更新indexCurrent，这样只要切换了就能暂停
    currentVideoPuase(index) {
        let curIdx = `video${index}`;//新的dom的id
        let videoContextPrev = wx.createVideoContext(this.data.indexCurrent, this)
        videoContextPrev.pause()
        this.setData({
            indexCurrent: curIdx//保存下来，就会成为上一个的id，方便暂停
        })
    },

    //设置活动详情的
    bindtapActiveBar(e) {
        this.setData({ activeIndex: e.currentTarget.dataset.index })
    },
    changeCurrent(e) {
        this.setData({ activeIndex: e.detail.current })
        this.setSwiperHeight(".timu_list" + e.detail.current)
    },
    //设置机构视频
    bindtapVideoBar(e) {
        this.setData({ videoIndex: e.currentTarget.dataset.index });
        //视频暂停函数的调用
        this.currentVideoPuase(e.currentTarget.dataset.index);

    },
    changeVideoCurrent(e) {
        this.setData({ videoIndex: e.detail.current })
        //视频暂停函数的调用
        this.currentVideoPuase(e.detail.current);
    },

    onReady() {
        //防止数据没有加载完成1表秒之后获取
        setTimeout(() => {
            this.setSwiperHeight(".timu_list0")
        }, 3000)

    },
    //设置swiper高度的方法
    setSwiperHeight(dom) {
        let query = wx.createSelectorQuery();
        var that = this
        query.select(dom).boundingClientRect(rect => {
            let clientHeight = rect.height;
            let clientWidth = rect.width;
            let ratio = 750 / clientWidth;
            let height = clientHeight * ratio;
            that.setData({
                // 获取要循环标签的高度
                height: height,
            })
        }).exec();
    },
    //单独购买跳转页面
    toCourseOne(e) {
        wx.setStorageSync('buy_method', 1);//购买方式 1，单独购买
        wx.setStorageSync('buy_type', 1);
        wx.setStorageSync('price', 1);
        wx.setStorageSync('group_id', 0);
        wx.navigateTo({
            url: '/pages/course/course',
            success: (res) => {
                res.eventChannel.emit('acceptDataFromOpenerPage', { data: e.detail })
            },
        })
    },

    //跳转到我要参团的团列表
    toGroupList() {
        app.toManyGroupList();
    },

    //开团购买
    bindtoCourseTwo(e) {
        wx.setStorageSync('activity_type', 2);//活动类型 :1单商家，2多商家
        wx.setStorageSync('buy_method', 2);//购买方式 1 表示直接购买，购买方式 2，参团购买，这里是开团，参团的话，直接跳转到团列表页选择团
        wx.navigateTo({
            url: '/pages/course/course',
            success: (res) => {
                res.eventChannel.emit('acceptDataFromOpenerPage', { data: e.detail })
            },
        })
    },
    //info数据的获取
    getActivityDetail: function (activity_id) {
        app.apiRequest({
            url: '/activity/detail/' + activity_id,
            method: 'get',
            data: {
            },
            success: res => {
                var that = this;
                console.log(res.data.response.end_time);
                that.setData({
                    info: res.data.response,
                    bannerInfo: res.data.response.bg_banner,
                    //价格的处理
                    oriPrice: util.cutZero(res.data.response.ori_price),
                    realPrice: util.cutZero(res.data.response.real_price),
                    oriPriceAfter: res.data.response.ori_price_after,
                    nowDate: res.data.response.end_time
                })
                this.countTime();
            }
        });
    },
    //地图设置家的位置
    setHomeAdress() {
        wx.navigateTo({
            url: "/pages/position/position",
        })
    },
    //初始化时，获取家的位置
    getHomeAdress() {
        app.apiRequest({
            url: '/user/info',
            method: 'get',
            data: {
            },
            success: res => {
                var that = this;
                that.setData({
                    'adressObj.name': res.data.response.address
                })
            }
        });
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
        // var keyName = app.globalData.userInfo.nickName;
        // if (options.id) {
        //     var id = options.id;
        //     wx.setStorageSync(keyName, id);
        // }
        // var activity_id = wx.getStorageSync(keyName);
        this.getActivityDetail( wx.getStorageSync('activity_id'));
        this.getHomeAdress();//初始化家的位置
        //加载页面时候就计算swiper
        this.setSwiperHeight(".timu_list0")
    },

    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function () {
        wx.hideHomeButton();
        //增加浏览数
        this.addViewNum();
    },

    //初始化时，获取家的位置
    addViewNum() {
        app.apiRequest({
            url: '/activity/view',
            method: 'get',
            data: {
                'activity_id': wx.getStorageSync('activity_id')
            },
            success: res => {
            }
        });
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

    },

    
    countTime() {
        var that = this;
        var days, hours, minutes, seconds;
        var nowDate = that.data.nowDate;
        var now = new Date().getTime();
        var end = new Date(nowDate).getTime(); //设置截止时间
        // console.log("开始时间：" + now, "截止时间:" + end);
        var leftTime = end - now; //时间差                       
        if (leftTime >= 0) {
            days = Math.floor(leftTime / 1000 / 60 / 60 / 24);
            hours = Math.floor(leftTime / 1000 / 60 / 60 % 24);
            minutes = Math.floor(leftTime / 1000 / 60 % 60);
            seconds = Math.floor(leftTime / 1000 % 60);
            seconds = seconds < 10 ? "0" + seconds : seconds
            minutes = minutes < 10 ? "0" + minutes : minutes
            hours = hours < 10 ? "0" + hours : hours
            that.setData({
                countdown: days + ":" + hours + "：" + minutes + "：" + seconds,
                days,
                hours,
                minutes,
                seconds
            })
            // console.log(that.data.countdown)
            //递归每秒调用countTime方法，显示动态时间效果
            setTimeout(that.countTime, 1000);
        } else {
            that.setData({
                countdown: '已截止'
            })
        }
    }
})