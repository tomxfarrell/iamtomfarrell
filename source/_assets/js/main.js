import "bootstrap";

const main1 = (function () {
  function testConsole() {
    console.log("testing");
  }

  return {
    testConsole: testConsole,
  };
})();

main1.testConsole();

require("./firebase");
