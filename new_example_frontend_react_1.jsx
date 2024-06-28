import DashLayout from '@/Layouts/DashLayout';
import React from 'react';
import Sidebar from '@/Components/Sidebar';
import Main from '@/Components/Main';
import MSChannelGraph from '@/Components/Graph/MSChannelGraph';
import DetailCard from '@/Components/Cards/DetailCards';
import InfoCard from '@/Components/Cards/InfoCards';
import FCLicense from '@/Components/Graph/FCLicense';
import MultiGauge from '@/Components/Graph/MultiGauge';
import Pie from '@/Components/Graph/Pie';

const Dashboard = (props) => {
    function Cards(cardsData) {
        return Object.entries(cardsData.cardsData).map((index) => (
            <InfoCard key={index[0]} title={index[0]} value={index[1]} changem={"N/A"} changey={"N/A"} />
        ));
    }

    return (
        <DashLayout>
            <FCLicense />
            <Sidebar company={"X"} />
            <Main>
                <div className="grid grid-cols-12 overflow-auto">
                    <Cards cardsData={props.cardsData} />
                    <InfoCard title="Other" value={"Test"} changem={"N/A"} changey={"N/A"} />
                    <InfoCard title="Other" value={"Test"} changem={"N/A"} changey={"N/A"} />
                    <MSChannelGraph title="Daily Channel Revenue" props={props.chanRevData} />
                    <Pie title="Device Conversion Rates" props={props.pie} />
                    <MultiGauge props={props.multi} />
                    <DetailCard title="Top Keywords Monthly" list={props.keywords} />
                    <DetailCard title="Top Performing Campaigns Monthly" list={props.adsCampaigns} />
                </div>
            </Main>
        </DashLayout>
    );
}

export default Dashboard;