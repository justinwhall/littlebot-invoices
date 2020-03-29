export const makeRequest = async (url, authCookie = true) => {
  const config = {
    method: 'GET',
    mode: 'cors',
    cache: 'no-cache',
    headers: {
      'Content-Type': 'application/json'
    },
    redirect: 'follow',
    referrerPolicy: 'no-referrer'
  };

  if (authCookie) {
    config.credentials = 'same-origin';
    config.headers['X-WP-Nonce'] = window.wpApiSettings.nonce;
  }

  const res = await fetch(url, config);
  const data = await res.json();

  return { data, headers: res.headers };
};

export const createCSV = lineItems => {
  let rows = [];

  lineItems.forEach(post => {
    const singleRow = [
      post.id,
      post.date,
      post.title.rendered,
      post.satus,
      post.lb_meta.total
    ];
    rows = [...rows, singleRow];
  });

  const commaList = rows.map(e => e.join(',')).join('\n');
  const csvContent = 'data:text/csv;charset=utf-8,' + commaList;
  const encodedUri = encodeURI(csvContent);
  const link = document.createElement('a');

  link.setAttribute('href', encodedUri);
  link.setAttribute('download', 'littlebot-report.csv');
  document.body.appendChild(link);

  link.click();
};
