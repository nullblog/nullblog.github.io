    </div>
    <div id="col-right" class="col-md-3 col-right">
      <div class="panel-heading">
        <h3 class="panel-title text-center">ブログ一覧</h3>
      </div>
      <div class="panel-body">
        <label for="blog-search">絞り込みform</label>
        <select id="blog-search" class="form-control">
          <option v-for="list in blogLists" value="{{ list.path }}">{{ list.genre }}</option>
        </select>
      </div>

      <table id="blog-histry" class="table table-striped">
        <tr v-for="list in blogLists">
          <td><a href="{{ list.href }}"><strong>{{ list.title }}</strong></a></td>
          <td><a href="{{ list.href }}"><small>{{ list.blogtype }}</small></a></td>
          <td><a href="{{ list.href }}"><small>{{ list.date }}</small></a></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<script src="/js/makelist.js"></script>
</body>
</html>
