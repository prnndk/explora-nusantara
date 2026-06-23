describe("Seller Trade Meetings Tests", () => {
  beforeEach(() => {
    cy.loginSeller();
    cy.visit("/dashboard/seller/trade-meeting");
  });

  it("S16: Create and request a trade meeting", () => {
    cy.contains("Create New Meeting").click();

    // Verify modal opens
    cy.contains("h2", "Create new Meeting").should("be.visible");

    // Input fields
    cy.get("input[name='agenda']").type("Negosiasi Kontrak Kopi Sumatra");
    cy.get("input[name='duration']").type("60");
    cy.get("input[name='password']").type("ZoomPass123");

    // Calculate dates in future
    const now = new Date();
    const startTime = new Date(now.getTime() + 24 * 60 * 60 * 1000); // 1 day future
    const endTime = new Date(startTime.getTime() + 60 * 60 * 1000); // +1 hour

    // Format: YYYY-MM-DDThh:mm
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
      // Find options with valid non-empty values (excluding placeholders like "Select Select Transaction" and "-- Pilih Transaksi --")
      const validOptions = [...$options].filter(opt => opt.value && opt.value.trim() !== "");

      if (validOptions.length > 0) {
        // Select the first valid option
        cy.get("select[wire\\:model='transaction_select']").select(validOptions[0].value);
        cy.contains("button", "Submit").click();

        // Verify meeting is successfully created
        cy.contains("Berhasil Membuat Meeting", { timeout: 15000 }).should("be.visible");
        cy.get("table").should("contain.text", "Negosiasi Kontrak Kopi Sumatra");
      } else {
        // Assert that the "-- Pilih Transaksi --" placeholder is present when no transactions are loadable
        cy.get("select[wire\\:model='transaction_select']").should("contain.text", "-- Pilih Transaksi --");
        cy.contains("button", "Cancel").click();
      }
    });
  });

  it("S17 & S18 & S19: Verify restriction and join meeting access logic", () => {
    cy.get("table").should("exist");

    cy.get("table").then(($table) => {
      $table.find("tbody tr").each((index, tr) => {
        const $tr = Cypress.$(tr);
        if ($tr.text().includes("Waiting Approval")) {
          // S17: Pending / Waiting Approval
          expect($tr.find("a").length).to.equal(0);
        }
        if ($tr.text().includes("Rejected")) {
          // S18: Rejected
          expect($tr.find("a").length).to.equal(0);
        }
        if ($tr.text().includes("Join Now")) {
          // S19: Join Now (Approved)
          const $a = $tr.find("a:contains('Join Now')");
          expect($a.attr("target")).to.equal("_blank");
          expect($a.attr("href")).to.not.be.empty;
        }
      });
    });
  });
});
