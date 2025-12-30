import type { ReactNode } from "react";
import clsx from "clsx";
import Heading from "@theme/Heading";
import styles from "./styles.module.css";

type FeatureItem = {
    title: string;
    image: string;
    description: ReactNode;
};

const FeatureList: FeatureItem[] = [
    {
        title: "Padronização Nacional",
        image: "/img/nfse-1.png",
        description: (
            <>
                Totalmente compatível com o padrão nacional da NFS-e (Receita
                Federal), seguindo rigorosamente os schemas e regras de
                validação.
            </>
        ),
    },
    {
        title: "DTOs Tipados e Validados",
        image: "/img/nfse-2.webp",
        description: (
            <>
                Utiliza <code>spatie/laravel-data</code> para garantir que seus
                dados estejam sempre corretos antes mesmo de gerar o XML.
            </>
        ),
    },
    {
        title: "Integração Simplificada",
        image: "/img/nfse-3.jpg",
        description: (
            <>
                Abstraia a complexidade técnica dos webservices e foque no que
                importa: a lógica de negócio da sua aplicação.
            </>
        ),
    },
];

function Feature({ title, image, description }: FeatureItem) {
    return (
        <div className={clsx("col col--4")}>
            <div className="text--center">
                <img src={image} className={styles.featureSvg} alt={title} />
            </div>
            <div className="text--center padding-horiz--md">
                <Heading as="h3">{title}</Heading>
                <p>{description}</p>
            </div>
        </div>
    );
}

export default function HomepageFeatures(): ReactNode {
    return (
        <section className={styles.features}>
            <div className="container">
                <div className="row">
                    {FeatureList.map((props, idx) => (
                        <Feature key={idx} {...props} />
                    ))}
                </div>
            </div>
        </section>
    );
}
