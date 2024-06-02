import { ref } from "vue";

export default function useToko() {

  const setNamaToko = (name) => {
    sessionStorage.setItem("toko", name);
  };

  const getNamaToko = () => {
    return sessionStorage.getItem("toko");
  };

  return {
    setNamaToko,
    getNamaToko,
  };
}
