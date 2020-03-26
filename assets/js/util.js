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
