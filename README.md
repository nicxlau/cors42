# cors42
#### Pull contents from any page via API (as JSON/P or raw) and avoid [Same-origin policy](https://en.wikipedia.org/wiki/Same-origin_policy) problems.

----

A free and open source [AnyOrigin](https://web.archive.org/web/20180807170914/http://anyorigin.com/) alternative, inspired by [Whatever Origin](http://WhateverOrigin.org).

### Examples

To get data from https://www.instagram.com/ using jQuery

```js
$.getJSON('https://cors42.herokuapp.com/?https://www.instagram.com/web/search/topsearch/?context=blended&query=nicolauns', function(data){
    alert(data);
});
```

## License

[MIT](LICENSE) © [Nic.](http://ndev.cf)
