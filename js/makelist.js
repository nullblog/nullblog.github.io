/**
 * blogのリストを取得して表示する
 */
$(function(){
var makeBlogList = function() {
  this.init.call(this);
}

/**
 * 初期化処理
 */
makeBlogList.prototype.init = function() {
  this.blogList = [];

  // 検索ボックスの方
  this.searchBoxVue = new Vue({
    el: '#blog-search',
    data: {
      blogLists: []
    },
    watch: {
      blogLists: this.searchList.bind(this)
    }
  });

  // ブログリストの方
  this.blogListVue = new Vue({
    el: '#blog-histry',
    data: {
      blogLists: []
    }
  });

  $('#blog-search').on('change', this.searchList.bind(this));
  this.getList();
}

/**
 * リストの取得
 * index.jsonからブログリストを取ってくる
 */
makeBlogList.prototype.getList = function() {
$.ajax({
  type: "GET",
  url: "/blog/index.json",
  dataType: "json",
  success: (function(data) {
    this.blogList = data;
    this.setSerchBox();
  }).bind(this)
});
}

/**
 * 検索用のselectboxの動的書き出し
 */
makeBlogList.prototype.setSerchBox = function() {
  var list = {};

  $.each(this.blogList, function(i, val){
    var tmp = val['blogtype'].split('/');

    val['blogtype'] = '/blog' + val['blogtype'];
    if(tmp[tmp.length - 1] == '') {
      tmp[tmp.length - 1] = '全部';
    }
    list[val['blogtype']] = {
      name: tmp[tmp.length - 1],
      genre: val['blogtype']};
  });

  this.searchBoxVue.$data.blogLists = objectSort(list);

  /**
   * objectをkeyでsortする
   * @param Object object
   */
  function objectSort(object) {
    var sorted = {};
    var array = [];

    // keyを取得する
    for (key in object) {
      if (object.hasOwnProperty(key)) {
        array.push(key);
      }
    }

    // keyをソート
    array.sort(); 

    // 返却用objectに値を入れなおす
    for (var i = 0, l = array.length; i < l; i++) {
      sorted[array[i]] = object[array[i]];
    }

    return sorted;
  }

}

/**
 * リストに書き出すブログの絞り込み
 * 検索条件を増やす時はこの辺りをいじる
 */
makeBlogList.prototype.searchList = function() {
  var type = $('#blog-search').val();
  var list = [];
  $.each(this.blogList, function(i, val){
    if(val['blogtype'].indexOf(type) !== -1) {
      list.push(val);
    }
  });

  this.blogListVue.$data.blogLists = list;
}

new makeBlogList();
});