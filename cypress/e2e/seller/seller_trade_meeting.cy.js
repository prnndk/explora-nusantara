describe("Seller Trade Meetings Tests", () => {
  beforeEach(() => {
    cy.loginSeller();
    cy.visit("/dashboard/seller/trade-meeting");
  });

  it("S16: Accept or reject a trade meeting request from Buyer", () => {
    cy.get("table").should("exist");

    cy.get("table").then(($table) => {
      cy.get("body").then(($body) => {
        // According to instrument, click "Accept" or "Reject" on list request
        if ($body.find("button:contains('Accept')").length > 0) {
          cy.contains("button", "Accept").first().click();
          cy.contains("Are you sure want to approve this meeting?").should("be.visible");
          cy.contains("button:visible", "No").click(); // close modal
        } else if ($body.find("button:contains('Reject')").length > 0) {
          cy.contains("button", "Reject").first().click();
          cy.contains("Are you sure want to reject this meeting?").should("be.visible");
          cy.contains("button:visible", "No").click(); // close modal
        }
      });
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
