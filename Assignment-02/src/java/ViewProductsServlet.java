/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/JSP_Servlet/Servlet.java to edit this template
 */

import java.io.*;
import java.sql.*;
import jakarta.servlet.*;
import jakarta.servlet.http.*;


/**
 *
 * @author AFRIN
 */

public class ViewProductsServlet extends HttpServlet {

    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /**
     * Handles the HTTP <code>GET</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html"); 
        response.setCharacterEncoding("UTF-8"); 
        PrintWriter out = response.getWriter();
        out.println("<html><head><title>View Products</title>");
        out.println("<style>");
        out.println("* { margin: 0; padding: 0; }");
        out.println("header { display: flex; align-items: center; justify-content: space-between; padding: 20px; margin-bottom: 30px; background-color: #ccccf0; }");
        out.println("table { border-collapse: collapse; width: 70%; margin: auto; }");
        out.println("th, td { padding: 20px; vertical-align: bottom; border: 1px solid #ddd; }");
        out.println("div { display: flex; justify-content: space-between; }");
        out.println("button { padding: 5px; width: 70px; }");
        out.println("h1{text-align: center; margin-bottom: 30px;}");
        out.println("</style></head><body>");
        out.println("<header><h1>Product Management</h1><nav><a href='index.html'>Add Product</a> | <a href='ViewProductsServlet'>View Products</a> | <a href='SearchProductsServlet'>Search Products</a></nav></header>");
        out.println("<main><h1>Product List</h1><table><thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead><tbody>");

        
        try{
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection conn= DriverManager.getConnection("jdbc:mysql://localhost:3306/product_management","root","afrinshah");
            Statement stmt= conn.createStatement();
            ResultSet rs= stmt.executeQuery("select*from products");
            while (rs.next()) {
                int id = rs.getInt("id");
                String name = rs.getString("name");
                String category = rs.getString("category");
                double price = rs.getDouble("price");
                int stock = rs.getInt("stock");
                
                out.println("<tr>");
                out.println("<td class='pid'>" + id + "</td>");
                out.println("<td class='pname'>" + name + "</td>");
                out.println("<td class='pcat'>" + category + "</td>");
                out.println("<td class='price'>Rs. " + price + "</td>");
                out.println("<td class='qty'>" + stock + "</td>");
                out.println("<td class='actions'><div>");
                out.println("<form action='EditProductServlet' method='get' style='display:inline-block;'>");
                out.println("<input type='hidden' name='id' value='" + id + "'>");
                out.println("<button class='editButton' type='submit'>Edit</button>");
                out.println("</form>");
                out.println("<form action='DeleteProductServlet' method='post' style='display:inline-block;'>");
                out.println("<input type='hidden' name='id' value='" + id + "'>");
                out.println("<button class='delButton' type='submit'>Delete</button>");
                out.println("</form>");
                out.println("</div></td>");
                out.println("</tr>");
            }
            
        rs.close();
        stmt.close();
        conn.close();
        }
        catch (Exception e) {
            out.println("<tr><td colspan='6'>Error fetching products.</td></tr>");
        }
        out.println("</tbody></table></main></body></html>");
    }
}
