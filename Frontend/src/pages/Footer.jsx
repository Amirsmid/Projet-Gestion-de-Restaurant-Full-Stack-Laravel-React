import { useEffect, useState } from "react";
import { GetParams } from "../Services/Parameter";

function Footer() {
    const [param, setParam] = useState();


    const GetParam = async () => {
        try {
            const res = await GetParams()
            setParam(res.data);
        } catch (error) {
            console.log(error);
        }
    };

    useEffect(() => {
        GetParam();
    }, []);

    return (
        <div>
            <footer className="footer_section">
                <div className="container">
                    <div className="row">
                        <div className="col-md-4 footer-col">
                            <div className="footer_contact">
                                <h4>
                                    Contact Us
                                </h4>
                                <div className="contact_link_box">
                                    <a >
                                        <i className="fa fa-map-marker" aria-hidden="true"></i>
                                        <span>
                                            {param?.adresse}
                                        </span>
                                    </a>
                                    <a >
                                        <i className="fa fa-phone" aria-hidden="true"></i>
                                        <span>
                                            Call {param?.tel}
                                        </span>
                                    </a>
                                    <a >
                                        <i className="fa fa-envelope" aria-hidden="true"></i>
                                        <span>
                                            {param?.email}
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div className="col-md-4 footer-col">
                            <div className="footer_detail">
                                <a className="footer-logo">
                                    {param?.nom}
                                </a>
                                <p>
                                    Necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with
                                </p>
                                <div className="footer_social">
                                    <a >
                                        <i className="fa fa-facebook" aria-hidden="true"></i>
                                    </a>
                                    <a >
                                        <i className="fa fa-twitter" aria-hidden="true"></i>
                                    </a>
                                    <a >
                                        <i className="fa fa-linkedin" aria-hidden="true"></i>
                                    </a>
                                    <a >
                                        <i className="fa fa-instagram" aria-hidden="true"></i>
                                    </a>
                                    <a >
                                        <i className="fa fa-pinterest" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div className="col-md-4 footer-col">
                            <h4>
                                Opening Hours
                            </h4>
                            <p>
                                Everyday
                            </p>
                            <p>
                                10.00 Am -10.00 Pm
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    )
}

export default Footer
