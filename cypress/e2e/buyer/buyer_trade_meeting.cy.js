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

  it("B16: Verify that Buyer cannot create a trade meeting directly", () => {
    // Assert that the meeting creation action triggers/buttons do not exist on the buyer interface
    cy.contains("Create New Meeting").should("not.exist");
    cy.contains("Create Meeting").should("not.exist");
  });
});
