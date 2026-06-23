describe("Seller Profile Management Tests", () => {
  beforeEach(() => {
    cy.loginSeller();
    cy.visit("/dashboard/user-profile");
  });

  it("S5: Access profile page and verify profile detail fields exist", () => {
    cy.get("h1").should("contain.text", "Seller Profile");
    cy.get("input[name='name']").should("exist");
    cy.get("input[name='nik']").should("exist");
    cy.get("[x-show*='detail'] input[name='phone']").should("exist");
    cy.get("input[name='address']").should("exist");
  });

  it("S6 & S8: Modify profile name, phone number, and address details", () => {
    // Clear and type new name
    cy.get("input[name='name']").clear().type("Zaki Raihansyah");
    // Clear and type phone number
    cy.get("[x-show*='detail'] input[name='phone']").clear().type("081231975100");
    // Clear and type address (S8)
    cy.get("input[name='address']").clear().type("Jl. Jetis Kulon VIII, Surabaya");

    // Save profile changes
    cy.contains("button", "Save").click();
    cy.contains("Profile").should("exist");
  });

  it("S21: Update banking information on Account tab", () => {
    // Switch to Account tab
    cy.contains("button", "Account").click();

    // Verify fields are visible
    cy.get("select[name='bank_name']").select("BCA");
    cy.get("input[name='bank_account_number']").clear().type("0102030405");

    // Save profile changes
    cy.contains("button", "Save").click();
  });

  it("Modify company details on Company tab", () => {
    // Switch to Company tab
    cy.contains("button", "Company").click();

    // Update fields
    cy.get("input[name='company_name']").clear().type("PT Seller Nusantara");
    cy.get("input[name='npwp']").clear().type("1234567890123456");
    cy.get("input[name='nib']").clear().type("1234567890123");
    cy.get("[x-show*='company'] input[name='phone']").clear().type("082134567891");
    cy.get("input[name='company_address']").clear().type("Jl. Sukolilo No. 12, Surabaya");

    // Save
    cy.contains("button", "Save").click();
  });

  it("S7: Upload or change profile picture", () => {
    // Open the modal by clicking the edit icon next to the username
    cy.contains("span", "sellerdemo").find("svg").click({ force: true });
    
    const fileName = "avatar.jpg";
    cy.contains("h3", "Update profile picture").should("be.visible");
    cy.contains("h3", "Update profile picture").parents("div.relative").first().within(() => {
      cy.get("input[name='profile_picture']").selectFile("cypress/fixtures/" + fileName, { force: true });
      cy.contains(fileName).should("be.visible");
      cy.contains("button", "Update Profile Picture").click({ force: true });
    });
    
    // Esc closes modal if still open, or check closing
    cy.get("body").type("{esc}");
  });

  it("S22: Show informative validation error on invalid file upload", () => {
    // Open the modal by clicking the edit icon next to the username
    cy.contains("span", "sellerdemo").find("svg").click({ force: true });
    
    const invalidFile = "invalid_doc.exe";
    cy.contains("h3", "Update profile picture").should("be.visible");
    cy.contains("h3", "Update profile picture").parents("div.relative").first().within(() => {
      cy.get("input[name='profile_picture']").selectFile("cypress/fixtures/" + invalidFile, { force: true });
      // Assert that a red validation error message appears
      cy.get(".text-red-500").should("be.visible");
    });
    // Esc closes modal
    cy.get("body").type("{esc}");
  });
});
