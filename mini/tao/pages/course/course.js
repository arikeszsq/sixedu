// pages/course/course.js
const app = getApp();
Page({
    /**
     * 页面的初始数据
     */
    data: {
        type: "",
        //家的地址
        adressObj: {
            latitude: '',
            longitude: '',
            name: '',
        },
        CourseCategroy: [],//分类和课程列表
        schoolLists: [],//选定课程后id,获取的课程校区列表
        indexSize: 0, // 当前点击课程分类，全部默认是0
        indicatorDots: false, // 是否显示面板指示点
        autoplay: false,  // 是否自动切换
        duration: 0,  // 滑动动画时长
        dialogShow: false,
        //四个校区的集合,需要发送给后端
        selectedCourse: [],
        //四个课程id,需要发后端
        selectedSchoolId: [],
        //单个选择校区的
        selectedSchool: {},
        //一次性保存，用来修改isSelected
        selectedCourseId: "",
    },

    //课程校区的获取
    getSchoolLists: function (e) {
        //这个id，存在地方isSelectd true
        const that = this
        let id = e.currentTarget.dataset.id;
        //取消选择
        const arryCourse = this.data.CourseCategroy[this.data.indexSize].children;
        console.log(arryCourse, "arryCourse")
        for (const item of arryCourse) {
            //根据资料里面值进行判断
            if (item.id === id && item.isSelected) {
                this.data.selectedCourse.splice(this.data.selectedCourse.indexOf(id), 1);
                this.data.selectedSchoolId.splice(this.data.selectedCourse.indexOf(id), 1);
                //需要重新设置一下isSelected
                item.isSelected = false
                that.setData({
                    selectedCourse: this.data.selectedCourse,
                    CourseCategroy: this.data.CourseCategroy
                })
                return
            }
        }
        if (that.data.selectedCourse.length >= 4) {
            wx.showToast({
                title: '选择的',
            })
            return
        }
        this.setData({
            selectedCourseId: id,
            dialogShow: true
        })
        // 第二次点击就是需要取消课程的
        app.apiRequest({
            url: '/course/company-child-lists/' + id,
            method: 'get',
            data: {
            },
            success: res => {
                var that = this;
                that.setData({
                    schoolLists: res.data.response
                })
            }
        });
    },
    nextHandle() {
        const length = this.data.selectedCourse.length
        if (length < 4) {
            wx.showToast({
                title: `还需要选择${4 - length}个课程`,
            })
            return
        } else {
            //课程储存到app.js得globalData里面
            //校区得id
            app.globalData.selectedCourse = this.data.selectedCourse;
            //课程得id
            app.globalData.selectedSchoolId = this.data.selectedSchoolId;
            wx.navigateTo({
                url: '/pages/activity/pay/index',
            })
        }


    },
    //辅助选中的函数
    isSelectedCourse(id, isSelected) {
        //////////////////////////////////////////////////////需要解决的问题
        //问题？？如何在总的分类里面选择，下面分类里面也需要选择
        const Choosechildren = this.data.CourseCategroy[this.data.indexSize].children
        for (const item of Choosechildren) {
            if (item.id === id) {
                item.isSelected = isSelected
            }
        }
        this.setData({
            CourseCategroy: this.data.CourseCategroy
        })
    },



    //选择校区的处理函数
    chooseSchoolHandle(e) {
        //选择的校区数据的展示
        let item = e.currentTarget.dataset.item
        this.setData({
            selectedSchool: item
        })

    },
    handleCancel() {
        this.setData({
            dialogShow: false
        })
    },
    handleComfire() {
        // 需要判断一下是否选择了，没有选择就需要提示
        if (Object.keys(this.data.selectedSchool).length == 0) {
            wx.showToast({
                title: '请选择校区',
                icon: 'error',
                duration: 2000
            })
            return
        }
        //集合selectedCourse，选中的id
        this.data.selectedCourse.push(this.data.selectedSchool.id);
        this.data.selectedSchoolId.push(this.data.selectedCourseId);

        this.setData({
            selectedCourse: this.data.selectedCourse,
            selectedSchoolId: this.data.selectedSchoolId,
            dialogShow: false,
            selectedSchool: {}
        })
        // console.log(this.data.selectedCourse, "id");
        //设置列表页面的选中状态
        this.isSelectedCourse(this.data.selectedCourseId, true)
    },

    /**
     * 一级分类选择
     */
    chooseTypes: function (e) {

        this.setData({
            indexSize: e.target.dataset.index
        })
    },

    //地图设置家的位置
    setHomeAdress() {
        wx.navigateTo({
            url: "/pages/position/position",
        })
    },
    searchNearOrgan() {
        wx.navigateTo({
            url: "/pages/checkSchool/checkSchool",
        })
    },

    //课程分类的获取
    getCourseCategroy: function () {
        app.apiRequest({
            url: '/course/lists',
            method: 'get',
            data: {
                'activity_id':  wx.getStorageSync('activity_id')
            },
            success: res => {
                var that = this;
                //给children里面加isSelectd属性
                for (const item of res.data.response) {
                    for (const iterator of item.children) {
                        iterator.isSelected = false
                        console.log(iterator, "1sss")
                    }
                }
                console.log(res.data.response, "ddd")
                that.setData({
                    CourseCategroy: res.data.response
                })
            }
        });
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad(options) {
        this.getCourseCategroy();
        var buy_type = wx.getStorageSync('buy_type');
        console.log(buy_type)
        // 家的位置的设置
        const obj = wx.getStorageSync('trueCity')
        if (obj.latitude) {
            console.log('adressObj:' + JSON.stringify(obj));
            this.setData({
                adressObj: obj
            })
            return false;
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
    onShow: function () {
        //设置家的地址修改之后
        const obj = wx.getStorageSync('trueCity');
        if (this.data.flag) {
            if (obj.longitude != this.data.adressObj.longitude || obj.latitude != this.data.adressObj.latitude) {
                console.log('adressObj:' + JSON.stringify(obj));
                this.setData({
                    adressObj: obj,
                    index: 0
                });
            }
        }
        this.setData({
            flag: true
        })
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