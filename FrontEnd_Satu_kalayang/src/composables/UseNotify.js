import { useQuasar } from "quasar";

export default function useNotify() {
  const $q = useQuasar();

  const notifySuccess = (message) => {
    $q.notify({
      type: "positive",
      message: message || "Success ✅",
      timeout: 1000,
      actions: [
        {
          label: "Ok",
          color: "white",
        },
      ],
    });
  };

  const notifyError = (message) => {
    $q.notify({
      type: "negative",
      message: message || "Someting wrong 😢",
      timeout: 1000,
      actions: [
        {
          label: "Ok",
          color: "white",
        },
      ],
    });
  };

  const notifyWarning = (message) => {
    $q.notify({
      type: "warning",
      message: message || "Attention ⚠️",
      textColor: "white",
      timeout: 1000,
      actions: [
        {
          label: "Ok",
          color: "white",
        },
      ],
    });
  };
  const notifyOngoing = (onMessage, message, type) => {
    const notif = $q.notify({
      type: "ongoing",
      textColor: "white",
      message: onMessage || "A moment... ⏱️",
    });

    setTimeout(() => {
      notif({
        type: type,
        message: message || "Back to setTimeout",
        timeout: 1000,
        actions: [
          {
            label: "Ok",
            color: "white",
          },
        ],
      });
    }, 3000);
  };

  return {
    notifySuccess,
    notifyError,
    notifyWarning,
    notifyOngoing,
  };
}
