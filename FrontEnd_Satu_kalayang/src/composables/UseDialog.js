import { useQuasar } from "quasar";

export default function useDialog() {
  const $q = useQuasar();

  function dialogShow({ tittle: tittle, message: message }) {
    return $q.dialog({
      title: tittle || "Confirmation",
      message: message || "Dialig Message",
      cancel: true,
      persistent: true,
    });
  }

  return {
    dialogShow,
  };
}
