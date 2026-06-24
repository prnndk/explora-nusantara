// Custom Commands for Explora Nusantara E2E Testing using cy.session()

Cypress.Commands.add("loginBuyer", () => {
  cy.session("buyer-session", () => {
    cy.visit("/login");
    cy.get("#username").type("buyerdemo");
    cy.get("#password").type("Password1234#");
    cy.contains("button", "Login").click();
    cy.url().should("include", "/dashboard/buyer");
  });
});

Cypress.Commands.add("loginSeller", () => {
  cy.session("seller-session", () => {
    cy.visit("/login");
    cy.get("#username").type("sellerdemo");
    cy.get("#password").type("Password1234#");
    cy.contains("button", "Login").click();
    cy.url().should("include", "/dashboard/seller");
  });
});

Cypress.Commands.add("loginAdmin", () => {
  cy.session("admin-session", () => {
    cy.visit("/login");
    cy.get("#username").type("admindemo");
    cy.get("#password").type("Password1234#");
    cy.contains("button", "Login").click();
    cy.url().should("include", "/dashboard/admin");
  });
});
