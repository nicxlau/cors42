# cors42
#### Pull contents from any page via API (as JSON/P or raw) and avoid [Same-origin policy](https://en.wikipedia.org/wiki/Same-origin_policy) problems.

----

A free and open source [AnyOrigin](https://web.archive.org/web/20180807170914/http://anyorigin.com/) alternative, inspired by [Whatever Origin](http://WhateverOrigin.org).

### Examples

To `fetch` data from https://www.instagram.com/:

```js
fetch(`https://cors42.000webhostapp.com/?https://www.instagram.com/web/search/topsearch/?context=blended&query=nicolauns`)
  .then(response => {
    if (response.ok) return response.json()
    throw new Error('Network response was not ok.')
  })
  .then(data => console.log(data));
```

Or with jQuery

```js
$.getJSON('https://cors42.000webhostapp.com/?https://www.instagram.com/web/search/topsearch/?context=blended&query=nicolauns', function(data){
    alert(data);
});
```

## License

[MIT](LICENSE) © [Nic.](http://ndev.cf)
