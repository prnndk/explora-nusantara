describe("Buyer Trade Meetings Tests", () => {
  beforeEach(() => {
    cy.loginBuyer();
    cy.visit("/dashboard/buyer/trade-meeting");
  });

  it("B17 & B18 & B19: Access trade meetings list and verify access restrictions based on status", () => {
    cy.get("h1").should("contain.text", "Trade Meeting");
    cy.contains("Create New Meeting").should("not.exist");
    cy.get("table").should("exist");
    cy.get("table").find("tbody tr").should("have.length.at.least", 1);

    // Check if table contains meetings
    cy.get("table").then(($table) => {
      $table.find("tbody tr").each((index, tr) => {
        const $tr = Cypress.$(tr);
        if ($tr.text().includes("Waiting Approval")) {
          // B17: Verify that if a meeting is pending/waiting approval, it cannot be joined
          expect($tr.find("a").length).to.equal(0);
        }
        if ($tr.text().includes("Rejected")) {
          // B18: Verify that if a meeting is rejected, it cannot be joined
          expect($tr.find("a").length).to.equal(0);
        }
        if ($tr.text().includes("Join Now")) {
          // B19: Verify that approved meetings show Join Now with target="_blank"
          const $a = $tr.find("a:contains('Join Now')");
          expect($a.attr("target")).to.equal("_blank");
          expect($a.attr("href")).to.not.be.empty;
        }
      });
    });
  });

  it("B16: Create and request a trade meeting", () => {
    cy.contains("Create New Meeting").click();

    // Verify modal opens
    cy.contains("h2", "Create new Meeting").should("be.visible");

    // Input fields
    cy.get("input[name='agenda']").type("Negosiasi Kontrak Kopi Sumatra");
    cy.get("input[name='duration']").type("30");
    cy.get("input[name='password']").type("ZoomP123");

    // Calculate dates in future
    const now = new Date();
    const startTime = new Date(now.getTime() + 24 * 60 * 60 * 1000); // 1 day future
    const endTime = new Date(startTime.getTime() + 30 * 60 * 1000); // +30 minutes (matching duration)

    const formatDateTime = (date) => {
      const pad = (n) => (n < 10 ? "0" + n : n);
      return (
        date.getFullYear() +
        "-" +
        pad(date.getMonth() + 1) +
        "-" +
        pad(date.getDate()) +
        "T" +
        pad(date.getHours()) +
        ":" +
        pad(date.getMinutes())
      );
    };

    cy.get("input[name='start_time']").type(formatDateTime(startTime));
    cy.get("input[name='end_time']").type(formatDateTime(endTime));

    // Select transaction - wait for the dropdown to be rendered/loaded by Livewire
    cy.get("select[wire\\:model='transaction_select']", { timeout: 15000 }).should("exist");
    cy.get("select[wire\\:model='transaction_select']").find("option").then(($options) => {
      const validOptions = [...$options].filter(opt => opt.value && opt.value.trim() !== "");

      if (validOptions.length > 0) {
        // Select the first valid option
        cy.get("select[wire\\:model='transaction_select']").select(validOptions[0].value);
        cy.contains("button", "Submit").click();

        // Verify meeting is successfully created
        cy.contains("Berhasil Membuat Meeting", { timeout: 15000 }).should("be.visible");
        cy.get("table").should("contain.text", "Negosiasi Kontrak Kopi Sumatra");
      } else {
        cy.get("select[wire\\:model='transaction_select']").should("contain.text", "-- Pilih Transaksi --");
        cy.contains("button", "Cancel").click();
      }
    });
  });
});
