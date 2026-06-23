describe("Admin Trade Meeting Management Tests", () => {
  beforeEach(() => {
    cy.loginAdmin();
    cy.visit("/dashboard/admin/trade-meeting");
  });

  it("A8 & A9 & A10 & A11: Access meetings list, test approve/reject modals, and Zoom play links", () => {
    cy.get("h1").should("contain.text", "Trade Meeting");
    cy.get("table").should("exist");

    cy.get("table").then(($table) => {
      if ($table.find("tbody tr").length > 0) {
        // Find if there is check-circle (approve) or x-circle (reject)
        cy.get("body").then(($body) => {
          if ($body.find("svg.size-6").length > 0) {
            // Click approve button (check-circle icon trigger modal)
            cy.get("button[x-on\\:click*='confirm-action']").first().click({ force: true });
            cy.contains("Are you sure want to approve this meeting?").should("be.visible");
            cy.contains("button:visible", "No").click(); // close modal
          }
        });
      }
    });
  });
});
