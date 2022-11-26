const formatTime = date => {
    const year = date.getFullYear()
    const month = date.getMonth() + 1
    const day = date.getDate()
    const hour = date.getHours()
    const minute = date.getMinutes()
    const second = date.getSeconds()
    return `${[year, month, day].map(formatNumber).join('/')} ${[hour, minute, second].map(formatNumber).join(':')}`
}

const formatDate = (date, separator = '/') => {
    const year = date.getFullYear()
    const month = date.getMonth() + 1
    const day = date.getDate()
    return [year, month, day].map(formatNumber).join(separator);
}

const formatNumber = n => {
    n = n.toString()
    return n[1] ? n : `0${n}`
}

const cutZero = num => {
     //拷贝一份 返回去掉零的新串
     let newstr = num;
     //循环变量 小数部分长度
     let leng = num.length - num.indexOf('.') - 1;
     //判断是否有效数
     if (num.indexOf('.') > -1) {
       //循环小数部分
       for (let i = leng; i > 0; i--) {
         //如果newstr末尾有0
         if (
           newstr.lastIndexOf('0') > -1 &&
           newstr.substr(newstr.length - 1, 1) == 0
         ) {
           let k = newstr.lastIndexOf('0');
           //如果小数点后只有一个0 去掉小数点
           if (newstr.charAt(k - 1) == '.') {
             return newstr.substring(0, k - 1);
           } else {
             //否则 去掉一个0
             newstr = newstr.substring(0, k);
           }
         } else {
           //如果末尾没有0
           return newstr;
         }
       }
     }
     return num;

}
/**
 * 设置监听器 watch.js
 */
export function setWatcher(page) {
    let data = page.data;
    let watch = page.watch;
    Object.keys(watch).forEach(v => {
        let key = v.split('.'); // 将watch中的属性以'.'切分成数组
        let nowData = data; // 将data赋值给nowData
        for (let i = 0; i < key.length - 1; i++) { // 遍历key数组的元素，除了最后一个！
            nowData = nowData[key[i]]; // 将nowData指向它的key属性对象
        }
        let lastKey = key[key.length - 1];
        // 假设key==='my.name',此时nowData===data['my']===data.my,lastKey==='name'
        let watchFun = watch[v].handler || watch[v]; // 兼容带handler和不带handler的两种写法
        let deep = watch[v].deep; // 若未设置deep,则为undefine
        observe(nowData, lastKey, watchFun, deep, page); // 监听nowData对象的lastKey
    })
}
module.exports = {
    formatTime:formatTime,
    formatDate:formatDate,
    cutZero:cutZero,
}
