/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/JSP_Servlet/Servlet.java to edit this template
 */

import java.io.IOException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import jakarta.servlet.ServletException;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

/**
 *
 * @author AFRIN
 */
public class AddProductServlet extends HttpServlet {

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        
        response.setContentType("text/html");

        String name=request.getParameter("name");
        String category= request.getParameter("category");
        double price= Double.parseDouble(request.getParameter("price"));
        int stock= Integer.parseInt(request.getParameter("stock"));
        try{
           Class.forName("com.mysql.cj.jdbc.Driver");
           Connection conn=DriverManager.getConnection("jdbc:mysql://localhost:3306/product_management","root","afrinshah");
           PreparedStatement stmt=conn.prepareStatement("insert into products(name, category, price, stock) values(?,?,?,?)");
           stmt.setString(1,name);
           stmt.setString(2, category);
           stmt.setDouble(3, price);
           stmt.setInt(4, stock);
           stmt.executeUpdate();
           stmt.close();
           conn.close();
           response.getWriter().write("<script>alert('Product added successfully!'); window.location='index.html';</script>");
           
        } catch (Exception e) {
            e.printStackTrace();
            response.getWriter().write("<script>alert('Error adding product!'); window.location='index.html';</script>");
        }
    }
}
