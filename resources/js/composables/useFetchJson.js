import { fetchJson } from '@/utils/fetchJson';

/**
 * Composable to fetch JSON data using externally provided refs
 *
 * @param {Ref} data - Reference for storing fetched data
 * @param {Ref} error - Reference for storing errors
 * @param {Ref} loading - Reference for tracking loading state
 * @param {Object|string} options - Either a configuration object or a URL string
 * @param {string} [options.url] - The URL to fetch (mandatory if using an object)
 * @param {object} [options.data=null] - The data to send (if any)
 * @param {string} [options.method=null] - The method to use (GET, POST, PUT, DELETE, etc.)
 * @returns {Object} An object with the abort function
 * @property {Function} abort - Function to abort the request
 */
export function useFetchJson(data, error, loading, options) {
  // Reset state
  // data.value = null;
  // error.value = null;
  // loading.value = true;

  const { request, abort } = fetchJson(options);
  request
    .then(res => {
      data.value = res;
      loading.value = false;
    })
    .catch(err => {
      error.value = err;
      loading.value = false;
    });

  return { abort };
}